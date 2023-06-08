<?php namespace Modules\Ibanners\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Modules\Page\Entities\Page;

use Modules\Core\Support\Traits\AuditTrait;

class Banner extends Model
{
    use Translatable, MediaRelation, AuditTrait;

    public $translatedAttributes = [
        'title',
        'code_ads',
        'uri',
        'url',
        'active',
        'custom_html',
    ];

    protected $fillable = [
        'position_id',
        'order',
        'target',
        'title',
        'code_ads',
        'uri',
        'url',
        'type',
        'active',
        'external_image_url',
        'custom_html',
    ];
    protected $table = 'ibanners__banners';

    /**
     * @var string
     */
    private $linkUrl;

    /**
     * @var string
     */
    private $imageUrl;

    public function Position()
    {
        return $this->belongsTo(Position::class);
    }



    /**
     * returns slider image src
     * @return string|null full image path if image exists or null if no image is set
     */
    public function getImageUrl()
    {
        if($this->imageUrl === null) {
            if (!empty($this->external_image_url)) {
                $this->imageUrl = $this->external_image_url;
            } elseif (isset($this->files[0]) && !empty($this->files[0]->path)) {
                $this->imageUrl = $this->filesByZone('bannerimage')->first()->path_string;
            }
        }

        return $this->imageUrl;
    }


    /**
     * returns slider link URL
     * @return string|null
     */
    public function getLinkUrl()
    {
        if ($this->linkUrl === null) {
            if (!empty($this->url)) {
                $this->linkUrl = $this->url;
            } elseif (!empty($this->uri)) {
                $this->linkUrl = '/' . locale() . '/' . $this->uri;
            }
        }

        return $this->linkUrl;
    }
}
