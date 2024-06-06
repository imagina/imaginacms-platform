<?php

namespace Modules\Iblog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Iblog\Repositories\PostRepository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateIblog extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'iblog:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data Version 3 to 4';


    protected $post;

    protected $category;


    /**
     * Create a new command instance.
     *
     * @param PostRepository $post
     * @param CategoryRepository $category
     */
    public function __construct(PostRepository $post, CategoryRepository $category)
    {
        parent::__construct();

        $this->category = $category;
        $this->post = $post;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {

            DB::insert('insert into media__files ( is_folder, filename, path, folder_id) values (?, ?, ?, ?)', [1, 'media', '/assets/media', 0]);
            $media = DB::table('media__files')->select('id')->where('filename', 'media')->first()->id;
            DB::table('media__files')->where('folder_id', '0')->update(['folder_id' => $media]);
            DB::table('media__files')->where('id', $media )->update(['folder_id' => 0]);
            DB::insert('insert into media__files ( is_folder, filename, path, folder_id) values (?, ?, ?, ?)', [1, 'iblog', '/assets/iblog', 0]);
            $folderBlog = DB::table('media__files')->select('id')->where('filename', 'iblog')->first()->id;

            DB::insert('insert into media__files ( is_folder, filename, path, folder_id) values (?, ?, ?, ?)', [1, 'post', '/assets/iblog/post', $folderBlog]);
            DB::insert('insert into media__files ( is_folder, filename, path, folder_id) values (?, ?, ?, ?)', [1, 'category', '/assets/iblog/category', $folderBlog]);
            DB::insert('insert into media__files ( is_folder, filename, path, folder_id) values (?, ?, ?, ?)', [0, 'default', 'modules/iblog/img/post/default.jpg', 0]);

            $folderPost = DB::table('media__files')->select('id')->where('filename', 'post')->first()->id;
            $folderCategory = DB::table('media__files')->select('id')->where('filename', 'category')->first()->id;
            $defaultImage = DB::table('media__files')->select('id')->where('filename', 'default')->first()->id;
            $posts = $this->post->all();
            $locale = $this->ask("locale");
            foreach ($posts as $post) {
                if (validateJson($post->title) || validateJson($post->description) || validateJson($post->summary)) {
                    if (validateJson($post->title)) {
                        $title = json_decode($post->title);
                        $description = json_decode($post->description);
                        $summary = json_decode($post->summary);

                        foreach ($title as $i => $t) {
                            $data[$i]['title'] = $t;
                            $titlep = str_slug($t, '-');
                        }
                    } else {
                        $data[$locale]['title'] = $post->title;
                    }
                    if (validateJson($post->description)) {
                        foreach ($description as $i => $d) {
                            $data[$i]['description'] = $d;
                        }

                    } else {
                        $data[$locale]['description'] = $post->description;
                    }
                    if (validateJson($post->summary)) {
                        foreach ($summary as $i => $s) {
                            $data[$i]['summary'] = $s;
                        }
                    } else {
                        $data[$locale]['summary'] = $post->summary;
                    }
                } else {
                    $data[$locale] = [
                        'title' => $post->title,
                        'slug' => $post->slug,
                        'description' => $post->description,
                        'summary' => $post->summary
                    ];

                    $titlep = $post->slug;
                }

                if (isset($post->options->mainimage) && !strpos($post->options->mainimage, 'default.jpg')) {
                    $image = '/assets/iblog/post/' . $post->id . '.jpg';
                    DB::insert('insert into media__files ( is_folder, filename, path, extension, mimetype, folder_id) values (?, ?, ?,?,?,?)', [0, $titlep, $image, 'jpg', 'image/jpeg', $folderPost]);
                    $img = DB::table('media__files')->select('id')->where('filename', $titlep)->first();
                    $imgId = $img->id ?? $defaultImage;
                } else {
                    $imgId = $defaultImage;
                };
                DB::insert('insert into media__imageables (file_id, imageable_id, imageable_type, zone) values (?, ?, ?, ?)', [$imgId, $post->id, 'Modules\Iblog\Entities\Post', 'mainimage']);

                if (isset($post->metatitle)) {
                    $data[$locale]['meta_title'] = $post->metatitle;
                }
                if (isset($post->metadescrition)) {
                    $data[$locale]['meta_description'] = $post->options->metadescription;
                }
                $cats = $post->categories;
                $categoriesPost = array();
                foreach ($cats as $cat) {
                    array_push($categoriesPost, $cat->id);
                };
                $data['categories'] = $categoriesPost;
                $resd = $this->post->update($post, $data);
                $this->info($resd->id);

            }
            $categories = $this->category->all();
            foreach ($categories as $category) {
                if (validateJson($category->title) || validateJson($category->summary) || validateJson($category->description)) {
                    if (validateJson($category->title)) {
                        $title = json_decode($category->title);
                        foreach ($title as $i => $t) {
                            $data[$i]['title'] = $t;
                        }
                    } else {
                        $data[$locale]['title'] = $category->title;
                    }
                    if (validateJson($category->description)) {
                        $description = json_decode($category->description);

                        foreach ($description as $i => $d) {
                            $data[$i]['description'] = $d;
                        }
                    } else {
                        $data[$locale]['description'] = $category->description;
                    }
                    if (validateJson($category->summary)) {
                        $summary = json_decode($category->summary);
                        foreach ($summary as $i => $s) {
                            $data[$i]['summary'] = $s;

                        }
                    } else {
                        $data[$locale]['summary'] = $category->summary;
                    }
                    $titlec = $t;
                } else {
                    $data[$locale] = [
                        'title' => $category->title,
                        'slug' => $category->slug,
                        'description' => $category->description,
                        'summary' => $category->summary
                    ];
                    $titlec = $category->slug;
                }

                if (isset($category->options->mainimage) && !strpos($category->options->mainimage, 'default.jpg')) {
                    $image = '/assets/iblog/category/' . $category->id . '.jpg';
                    DB::insert('insert into media__files ( is_folder, filename, path, extension, mimetype, folder_id) values (?, ?, ?,?, ?, ?)', [0, $titlec, $image, 'jpg', 'image/jpeg', $folderCategory]);
                    $imgId = DB::table('media__files')->select('id')->where('filename', $titlec)->first();
                } else {
                    $imgId = $defaultImage;
                };
                DB::insert('insert into media__imageables (file_id, imageable_id, imageable_type, zone) values (?, ?, ?, ?)', [$imgId, $category->id, 'Modules\Iblog\Entities\Category', 'mainimage']);
                $resd = $this->category->update($category, $data);
                $this->info($resd->id);

            }
        } catch (\Exception $e) {
            \Log::error($e);
            $this->info($e->getMessage());
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     *
     *
     * protected function getArguments()
     * {
     * return [
     * ['locale', InputArgument::REQUIRED, 'locale valid'],
     * ];
     * }
     */
    /**
     * Get the console command options.
     *
     * @return array
     *
     * protected function getOptions()
     * {
     * return [
     * ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
     * ];
     * }*/
}
