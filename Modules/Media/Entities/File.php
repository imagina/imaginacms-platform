<?php

namespace Modules\Media\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Contracts\Support\Responsable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Isite\Traits\Tokenable;
use Modules\Media\Helpers\FileHelper;
use Modules\Media\Image\Facade\Imagy;
use Modules\Media\ValueObjects\MediaPath;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;
use Modules\User\Entities\Sentinel\User;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * Class File
 *
 * @property \Modules\Media\ValueObjects\MediaPath path
 */
class File extends CrudModel implements TaggableInterface, Responsable
{
    use Translatable, NamespacedEntity, TaggableTrait, BelongsToTenant, Tokenable;

    protected $table = 'media__files';

    public $transformer = 'Modules\Media\Transformers\MediaTransformer';

    public $entity = 'Modules\Media\Entities\File';

    public $repository = 'Modules\Media\Repositories\FileRepository';

    public $translatedAttributes = ['description', 'alt_attribute', 'keywords'];

    protected $fillable = [
        'id',
        'is_folder',
        'description',
        'alt_attribute',
        'keywords',
        'filename',
        'path',
        'extension',
        'mimetype',
        'width',
        'height',
        'filesize',
        'folder_id',
        'created_by',
        'has_watermark',
    'has_thumbnails',
    'disk'
    ];

    protected $appends = ['path_string', 'media_type'];

    protected $casts = ['is_folder' => 'boolean'];
  protected $with = ["createdBy","tags"];
    protected static $entityNamespace = 'asgardcms/media';

    public function parent_folder()
    {
        return $this->belongsTo(__CLASS__, 'folder_id');
    }

    public function getPathAttribute($value)
    {
        $disk = is_null($this->disk) ? setting('media::filesystem', null, config('asgard.media.config.filesystem')) : $this->disk;

        return new MediaPath($value, $disk, $this->organization_id, $this);
    }

    public function getPathStringAttribute()
    {
        return (string) $this->path;
    }

    public function getMediaTypeAttribute()
    {
        return FileHelper::getTypeByMimetype($this->mimetype);
    }

    public function getUrlAttribute()
    {
        if ($this->disk == 'privatemedia') {
            return \URL::route('public.media.media.show', ['criteria' => $this->id]);
        } else {
            return (string) $this->path;
        }
    }

    public function isFolder(): bool
    {
        return $this->is_folder;
    }

    public function isImage()
    {
        $imageExtensions = json_decode(setting('media::allowedImageTypes', null, config('asgard.media.config.allowedImageTypes')));

        return in_array(pathinfo($this->path, PATHINFO_EXTENSION), $imageExtensions);
    }

    public function isVideo()
    {
        $videoExtensions = json_decode(setting('media::allowedVideoTypes', null, config('asgard.media.config.allowedVideoTypes')));

        return in_array(pathinfo($this->path, PATHINFO_EXTENSION), $videoExtensions);
    }

    public function getThumbnail($type)
    {
        if ($this->isImage() && $this->getKey()) {
            return Imagy::getThumbnail($this, $type, $this->disk);
        }

        return false;
    }

    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return response()
          ->file(public_path($this->path->getRelativeUrl()), [
              'Content-Type' => $this->mimetype,
          ]);
    }

    /**
     * Created by relation
     *
     * @return mixed
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Imageable relation
     *
     * @return mixed
     */
    public function imageable()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * Created by relation
     *
     * @return mixed
     */
    public function folder()
    {
        return $this->belongsTo(File::class, 'folder_id');
    }
}
