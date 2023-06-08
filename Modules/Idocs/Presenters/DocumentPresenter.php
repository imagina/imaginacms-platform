<?php

namespace Modules\Idocs\Presenters;

use Laracasts\Presenter\Presenter;

class DocumentPresenter extends Presenter
{
    /**
     * @var \Modules\Idocs\Entities\Status
     */
    protected $status;
    /**
     * @var \Modules\Idocs\Repositories\DocRepository
     */
    private $document;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->document = app('Modules\Idocs\Repositories\DocumentRepository');
    }


    /**
     * Get the doc status
     * @return string
     */
    public function status()
    {
        if ($this->entity->status) {
            return trans('idocs::documents.status.active');
        }
        return trans('idocs::documents.status.inactive');

    }

    public function icon()
    {
        if ($this->entity->iconImage) {
            return '<img src="' . $this->entity->iconImage->path .' " width="50px">';
        }
        if (isset($this->entity->file->mimeType)) {
            switch ($this->entity->file->mimeType) {
                case 'application/pdf':
                    return '<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 32px"></i>';
                    break;
                case 'image/jpeg':
                    return '<i class="fa fa-file-image-o" aria-hidden="true" style="font-size: 32px"></i>';
                    break;
                case 'video/mp4':
                    return '<i class="fa fa-file-video-o" aria-hidden="true" style="font-size: 32px"></i>';
                    break;
                default:
                    return '<i class="fa fa-file-image-o" aria-hidden="true" style="font-size: 32px"></i>';
                    break;
            }
        }
        return '<i class="fa fa-times-circle" aria-hidden="true" style="font-size: 32px"></i>';
    }

    /**
     * Getting the label class for the appropriate status
     * @return string
     */
    public function statusLabelClass()
    {
        switch ($this->entity->status) {
            case 0:
                return 'bg-red';
                break;
            case 1:
                return 'bg-green';
                break;
        }
    }
}
