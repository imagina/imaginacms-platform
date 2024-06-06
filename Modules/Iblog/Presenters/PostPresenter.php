<?php

namespace Modules\Iblog\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Iblog\Entities\Status;

class PostPresenter extends Presenter
{
    /**
     * @var \Modules\Iblog\Entities\Status
     */
    protected $status;
    /**
     * @var \Modules\Iblog\Repositories\PostRepository
     */
    private $post;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->post = app('Modules\Iblog\Repositories\PostRepository');
        $this->status = app('Modules\Iblog\Entities\Status');
    }

    /**
     * Get the previous post of the current post
     * @return object
     */
    public function previous()
    {
        return $this->post->getPreviousOf($this->entity);
    }

    /**
     * Get the next post of the current post
     * @return object
     */
    public function next()
    {
        return $this->post->getNextOf($this->entity);
    }

    /**
     * Get the post status
     * @return string
     */
    public function status()
    {
        return $this->status->get($this->entity->status);
    }

    /**
     * Getting the label class for the appropriate status
     * @return string
     */
    public function statusLabelClass()
    {
        switch ($this->entity->status) {
            case Status::DRAFT:
                return 'bg-red';
                break;
            case Status::PENDING:
                return 'bg-orange';
                break;
            case Status::PUBLISHED:
                return 'bg-green';
                break;
            case Status::UNPUBLISHED:
                return 'bg-purple';
                break;
            default:
                return 'bg-red';
                break;
        }
    }

    public function mainImage($post,$thumbnail=null)
    {
        $item=$post->mainimage2;
        $path=$thumbnail?:$post->path;
        switch ($item->mimetype) {
            case 'image/jpg':
            case 'image/png':
            case 'image/jpeg':
            case 'image/gif':
            case 'image/bmp':
                return "<img class='img-fluid w-100'
                             src='$item->path'
                             alt='$this->title'/>";
                break;
            case 'aplication/pdf':
                return "<a class='btn btn-primary '
                             href='$item->path'
                             title='$this->title'/>";
                break;
            case 'audio/mp3':
                return "<div class='frame-audio'>
                            <audio class='w-100' controls='' preload='none' src=$item->path>
                Tú navegador no soporta este reproductor, actualízalo.
                            </audio>
                        </div>";
                break;
            case 'video/mp4':
                return "<video width='320' height='240' controls>
                        <source src='$item->path' type='$item->maintype'>
                        Tú navegador no soporta este reproductor, actualízalo.
                        </video>";
                break;
            default:
                return "<a class='btn btn-primary '
                             href='$item->path'
                             title='$this->title'/>";
                break;
        }
    }
}
