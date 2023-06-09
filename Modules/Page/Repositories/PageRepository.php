<?php

namespace Modules\Page\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;
use Modules\Page\Entities\Page;

interface PageRepository extends BaseRepository
{
    /**
     * Find the page set as homepage
     *
     * @return object
     */
    public function findHomepage();

    /**
     * Count all records
     *
     * @return int
     */
    public function countAll();

    /**
     * @return object
     */
    public function findBySlugInLocale($slug, $locale);

    /**
     * Paginating, ordering and searching through pages for server side index table
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;

    /**
     * @return mixed
     *
     * @internal param int $pageId
     */
    public function markAsOnlineInAllLocales(Page $page);

    /**
     * @param  array  $pageIds [int]
     * @return mixed
     */
    public function markMultipleAsOnlineInAllLocales(array $pageIds);

    /**
     * @return mixed
     *
     * @internal param int $pageId
     */
    public function markAsOfflineInAllLocales(Page $page);

    /**
     * @param  array  $pageIds [int]
     * @return mixed
     */
    public function markMultipleAsOfflineInAllLocales(array $pageIds);

    public function getItemsBy($params);

    public function getItem($criteria, $params = false);

    public function create($data);

    public function updateBy($criteria, $data, $params = false);

    public function deleteBy($criteria, $params = false);
}
