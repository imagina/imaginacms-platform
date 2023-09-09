<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 10/10/2018
 * Time: 5:26 PM
 */

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ilocations\Transformers\CityTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;
use Modules\Iplaces\Entities\Gama;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Entities\StatusYN;
use Modules\Iplaces\Entities\Weather;
use Modules\Isite\Transformers\RevisionTransformer;
use Modules\Ischedulable\Transformers\ScheduleTransformer;

class PlaceTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $includes = explode(',', $request->include);

        $gama = new Gama();
        $weather = new Weather();
        $status = new Status();
        $statusYN = new StatusYN();

        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'statusName' => $status->get($this->status),
            'summary' => $this->summary,
            'description' => $this->description,
            'address' => $this->address,
            'phone1' => $this->when($this->options, $this->options->phone1 ?? ''),
            'phone2' => $this->when($this->options, $this->options->phone2 ?? ''),
            'phone3' => $this->when($this->options, $this->options->phone3 ?? ''),
            'mainImage' => $this->main_image,
            'gama' => $this->gama,
            'gamaNAME' => $gama->get($this->gama),
            'quantityPerson' => $this->quantity_person,
            'weather' => $this->weather,
            'weatherName' => $weather->get($this->weather),
            'housing' => $this->housing,
            'housingName' => $statusYN->get($this->housing),
            'transport' => $this->transport,
            'transportName' => $statusYN->get($this->transport),
            'metaTitle' => $this->meta_title ?? $this->title,
            'metaDescription' => $this->meta_description ?? $this->summary,
            'metaKeywords' => $this->meta_keywords,
            'createdAt' => ($this->created_at),
            'updatedAt' => ($this->updated_at),
            'cityId' => $this->city_id,
            'provinceId' => $this->province_id,
            'zone' => $this->zone_id,
      'schedule' => new ScheduleTransformer($this->whenLoaded('schedule')),
            'categoryId' => $this->category_id,
            'options' => $this->options,
            'mediaFiles' => $this->mediaFiles(),
            'rating' => $this->rating,
      'sortOrder' => $this->sort_order ?? 0,
            //Relations
            'services' => ServiceTransformer::collection($this->whenLoaded('services')),
            'category' => new CategoryTransformer($this->whenLoaded('category')),
            'categories' => CategoryTransformer::collection($this->whenLoaded('categories')),
            'zone' => new ZoneTransformer($this->whenLoaded('zone')),
            'province' => new ProvinceTransformer($this->whenLoaded('province')),
            'city' => new CityTransformer($this->whenLoaded('city')),
            'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
        ];

        foreach ($this->tags as $tag) {
            $data['tags'][] = $tag->name;
        }

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['title'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['description'] ?? '' : '';
                $data[$lang]['summary'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['summary'] ?? '' : '';
                $data[$lang]['slug'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['slug'] : '';
                $data[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['meta_title'] : '';
                $data[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['meta_description'] : '';
            }
        }

        return $data;
    }
}
