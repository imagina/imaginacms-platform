<?php

namespace Modules\Tag\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Tag\Events\TagIsCreating;
use Modules\Tag\Events\TagIsUpdating;
use Modules\Tag\Events\TagWasCreated;
use Modules\Tag\Events\TagWasUpdated;
use Modules\Tag\Repositories\TagRepository;

class EloquentTagRepository extends EloquentBaseRepository implements TagRepository
{
    /**
     * Get all the tags in the given namespace
     */
    public function allForNamespace($namespace)
    {
        return $this->model->with('translations')->where('namespace', $namespace)->get();
    }

    public function create($data)
    {
        event($event = new TagIsCreating($data));
        $tag = $this->model->create($event->getAttributes());

        event(new TagWasCreated($tag));

        return $tag;
    }

    public function update($tag, $data)
    {
        event($event = new TagIsUpdating($tag, $data));
        $tag->update($event->getAttributes());

        event(new TagWasUpdated($tag));

        return $tag;
    }

    public function getItemsBy($params = false)
    {
        $tags = collect();
        $taggable = collect(\DB::table('tag__tagged')->where('tag_id', $params->filter->tagId)->get());
        $taggable = $taggable->groupBy('taggable_type');
        foreach ($taggable as $key => $entity) {
            $repository = config('asgard.tag.config.repositoriesEntities.'.$key);
            if (! is_null($repository)) {
                $repository = app($repository);
                $tag = $repository->getItemsBy($params);
                $tags = $tags->concat($tag);
            }
        }

        return $tags;
    }
}
