<?php

namespace Modules\Ichat\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface MessageRepository extends BaseRepository
{
  /**
   * Return the latest x blog posts
   * @param Object $params
   * @return Collection
   */
  public function getItemsBy($params);

  /**
   * Return the latest x blog posts
   * @param Object $params
   * @return Collection
   */
  public function getItem($criteria, $params = false);

  /**
   * Return the latest x blog posts
   * @param Object $params
   * @return Collection
   */
  public function create($data);

  /**
   * Return the latest x blog posts
   * @param Object $params
   * @return Collection
   */
  public function updateBy($criteria, $data, $params = false);

  /**
   * Return the latest x blog posts
   * @param Object $params
   * @return Collection
   */
  public function deleteBy($criteria, $params = false);
}
