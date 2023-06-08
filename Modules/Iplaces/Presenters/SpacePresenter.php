<?php

namespace Modules\Iplaces\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Iplaces\Entities\Status;


class SpacePresenter extends Presenter
{
    /**
     * @var \Modules\Iplaces\Entities\Status
     */
    protected $status;
    private $space;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->space = app('Modules\Iplaces\Repositories\SpaceRepository');
        $this->status = app('Modules\Iplaces\Entities\Status');
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
            case Status::INACTIVE:
                return 'bg-red';
                break;

            case Status::ACTIVE:
                return 'bg-green';
                break;

            default:
                return 'bg-red';
                break;
        }
    }
}
