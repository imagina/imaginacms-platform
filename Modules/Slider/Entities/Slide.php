<?php

namespace Modules\Slider\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Page\Entities\Page;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Slide extends Model
{
    use Translatable, MediaRelation, BelongsToTenant, AuditTrait, RevisionableTrait;

    public $transformer = 'Modules\Slider\Transformers\SlideApiTransformer';

    public $entity = 'Modules\Slider\Entities\Slide';

    public $repository = 'Modules\Slider\Repositories\SlideApiRepository';

    public $translatedAttributes = [
        'title',
        'caption',
        'uri',
        'url',
        'active',
        'custom_html',
        'summary',
    ];

    protected $fillable = [
        'slider_id',
        'page_id',
        'position',
        'target',
        'title',
        'caption',
        'uri',
        'url',
        'type',
        'active',
        'external_image_url',
        'custom_html',
        'responsive',
        'options',
    ];

    protected $table = 'slider__slides';

    /**
     * @var string
     */
    private $linkUrl;

    /**
     * @var string
     */
    private $imageUrl;

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }

    /**
     * Check if page_id is empty and returning null instead empty string
     */
    public function setPageIdAttribute($value): number
    {
        $this->attributes['page_id'] = ! empty($value) ? $value : null;
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * returns slider image src
     *
     * @return string|null full image path if image exists or null if no image is set
     */
    public function getImageUrl(): ?string
    {
        if ($this->imageUrl === null) {
            if (! empty($this->external_image_url)) {
                $this->imageUrl = $this->external_image_url;
            } elseif (isset($this->files[0]) && ! empty($this->files[0]->path)) {
                $this->imageUrl = $this->filesByZone('slideimage')->first()->path;
            }
        }

        return $this->imageUrl;
    }

    /**
     * returns slider link URL
     */
    public function getLinkUrl(): ?string
    {
        if ($this->linkUrl === null) {
            if (! empty($this->url)) {
                $this->linkUrl = $this->url;
            } elseif (! empty($this->uri)) {
                $this->linkUrl = '/'.locale().'/'.$this->uri;
            } elseif (! empty($this->page)) {
                $this->linkUrl = route('page', ['uri' => $this->page->slug]);
            }
        }

        return $this->linkUrl;
    }

    /**
     * returns slider link URL
     */
    public function getUrlAttribute(): ?string
    {
        $url = '';
        if (! empty($this->attributes['url'])) {
            $url = $this->attributes['url'];
        } elseif (! empty($this->uri)) {
            $url = \LaravelLocalization::localizeUrl('/'.$this->uri);
        } elseif (! empty($this->page)) {
            $url = route('page', ['uri' => $this->page->slug]);
        }

        return $url;
    }

    protected function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }
}
