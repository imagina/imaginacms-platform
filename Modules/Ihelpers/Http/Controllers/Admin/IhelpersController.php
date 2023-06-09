<?php

namespace Modules\Ihelpers\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ihelpers\Other\ImResponseCache\ImResponseCache;

class IhelpersController extends AdminBaseController
{
    public $routesXml = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function clearcache()
    {
        $imresponsecache = resolve(ImResponseCache::class);
        //Clear cache for spatie cache.
        $imresponsecache->flush();
        //Clear page cache in html files.
        $imresponsecache->flushPageCache();

        return redirect()->route('dashboard.index')
            ->withSuccess(trans('ihelpers::common.cache_cleared'));
    }

    /*
    * This method create Array with Url's of project
    */
    public function makeArrayRoutes()
    {
        $routes = [];
        $configuration = json_decode(json_encode(config('asgard.ihelpers.config.configurationv2')));
        $manufacturers = [];
        foreach ($configuration as $config) {
            $routesCategories = []; //Routes with categories,sub-category and products
            $routesPages = []; //Routes of pages.
            if ($config->Categories) {
                $routesCategories = []; //Routes with categories,sub-category and products
                $repository = app($config->Repository); //Instance repository
                $categories = $repository->findParentCategories(); //Get all Parent Categories
                foreach ($categories as $category) {
                    $elements = app($config->RepositoryItems);
                    $routesCategories[] = $this->category($category, $elements);
                }
                $routes[$config->Name] = $routesCategories;
            } else {
          //No categories - example: Pages
                $repository = app($config->Repository); //Instance repository
                $pages = $repository->all();
                foreach ($pages as $page) {
                    $title = '';
                    $url = '';
                    if (isset($page->name)) {
                        $title = $page->name;
                    }
                    if (isset($page->title)) {
                        $title = $page->title;
                    }
                    if (isset($page->slug)) {
                        $url = env('APP_URL').'/'.$page->slug;
                    } else {
                        $url = env('APP_URL').'/brands/'.$page->id;
                    }
                    $routesPages[] = [
                        'title' => $title,
                        'url' => $url,
                    ];
                }//pages
                $routes[$config->Name] = $routesPages;
            }
        }//foreach config

        return json_decode(json_encode($routes));
    }//makeArrayRoutes()

    public function category($category, $product, $data = [], $items = [])
    {
        $children = [];
        $data = [
            'title' => $category->title,
            'url' => env('APP_URL').'/'.$category->slug,
        ];
        $products = $product->category($category->id);
        if (count($products)) {
            foreach ($products as $index => $item) {
                $items[] = ['title' => $item->title, 'url' => env('APP_URL').'/'.$item->slug];
            }
            $data['items'] = $items;
        }
        if (count($category->children)) {
            foreach ($category->children as $child) {
                $children[] = $this->category($child, $product);
            }
            $data['children'] = $children;
        }

        return $data;
    }

    /*
    * This method return view to generate sitemap
    */
    public function sitemapGet()
    {
        return view('ihelpers::indexSiteMap');
    }//sitemapGet()

    public function recursive($array)
    {
        foreach ($array as $child) {
            if (isset($child->items)) {
                foreach ($child->items as $item) {
                    $this->routesXml[] = [
                        'title' => $item->title,
                        'url' => $item->url,
                    ];
                }//items
            }//items
            if (isset($child->children)) {
                $this->recursive($child->children);
            }//isset children
        //items
        }// foreach array child
    }//recursive($array)

    //sitemapPostv3
    public function siteMapPost()
    {
        try {
        ////////////////////////////////////////Load in variable publishes all routes
            $routes = $this->makeArrayRoutes(); //Get array of routes
            Storage::disk('publicmedia')->put('sitemap.json', json_encode($routes)); //Save in disk publicmedia sitemap.json with all routes
            foreach ($routes as $module => $route) {
                foreach ($route as $r) {
                    $this->routesXml[] = [
                        'title' => $r->title,
                        'url' => $r->url,
                    ];
                    if (isset($r->items)) {
                        foreach ($r->items as $item) {
                            $this->routesXml[] = [
                                'title' => $item->title,
                                'url' => $item->url,
                            ];
                        }
                    }//items
                    if (isset($r->children)) {
                        foreach ($r->children as $child) {
                            $this->routesXml[] = [
                                'title' => $child->title,
                                'url' => $child->url,
                            ];
                            if (isset($r->children)) {
                                $this->recursive($r->children);
                            }//isset children
                        }//children routes
                    }//isset children
                }//foreach route
            }//foreach modules
        ////////////////////////////////////////Load in variable publishes all routes
            /*Public variable with routes: $this->routesXml
            Structure of variable is two fields: title and url.
            */
        //Construct sitemaps xml
            $b = 0; //Flag of first url
            $counter = 0; //Counter Routes in xml
            $sitemapCounter = 0; //Counter xml's file -- 100 routes per sitemap.xml
            $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $xml .= '<url><loc>'.env('APP_URL').'</loc>
        <lastmod>'.date('Y-m-d').'</lastmod>
        <priority>1.00</priority></url>';
            $this->routesXml = json_decode(json_encode($this->routesXml)); //Collection of routes
            foreach ($this->routesXml as $route) {
                if ($counter == 100) {
                    //End of xml
                    $xml .= '</urlset>';
                    // Create the sitemap xml
                    Storage::disk('publicmedia')->put('sitemap-'.$sitemapCounter.'.xml', $xml);
                    // reset the counter
                    $counter = 0;
                    // count generated sitemap
                    $sitemapCounter++;
                    //Init new xml text
                    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                }//counter==100
                $xml .=
                '<url>
          <loc>'.$route->url.'</loc>
          <lastmod>'.date('Y-m-d').'</lastmod>
          <priority>1.00</priority>
          </url>';
                $counter++;
            }//foreach routes
            ///////End foreach routes
            if ($counter > 0) {
                $xml .= '</urlset>';
                Storage::disk('publicmedia')->put('sitemap-'.$sitemapCounter.'.xml', $xml);
                $sitemapCounter++;
                $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">';
            }//counter>0
            //Make sitemap.xml index and relation with others sitemap
            for ($i = 0; $i < $sitemapCounter; $i++) {
                $xml .= '<sitemap><loc>'.env('APP_URL').'/sitemap-'.$i.'.xml</loc>
              <lastmod>'.date('Y-m-d').'</lastmod>
            </sitemap>';
            }//for sitemapCounter
            $xml .= '</sitemapindex>'; //close sitemapindex
            Storage::disk('publicmedia')->put('sitemap.xml', $xml); //Make sitemap.xml,
            $content = "User-agent: *\n";
            $content .= "Disallow: api/* \n";
            $content .= "Disallow: review/* \n";
            $content .= "\nSitemap: ".env('APP_URL').'/sitemap.xml';
            Storage::disk('publicmedia')->put('robots.txt', $content); //Make robots.txt

            return ['success' => 1,
                'QuantityOfSiteMap' => $sitemapCounter,
                'QuantityOfUrl' => count($this->routesXml) + 1,
                'Routes' => $this->routesXml,
                'SiteXmlPath' => env('APP_URL').'/sitemap.xml'];
        } catch(\Exception $e) {
            return ['success' => 0, 'message' => $e->getMessage()];
        }
    }//siteMapPost()
}
