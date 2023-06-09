<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ilocations\Repositories\CityRepository;

class EloquentCityRepository extends EloquentBaseRepository implements CityRepository
{
    public function index($page, $take, $filter, $include, $fields)
    {
        //Initialize Query
        $query = $this->model->query();

        /*== FILTER ==*/
        if ($filter) {
            /**
             * @deprecated Use $filter->country or $filter->province instead
             */
            if (isset($filter->country_id)) {
                $query->where('country_id', $filter->country_id);
            }
            if (isset($filter->province_id)) {
                $query->where('province_id', $filter->province_id);
            }
            if (isset($filter->country)) {
                $query->where('country_id', $filter->country);
            }
            if (isset($filter->province)) {
                $query->where('province_id', $filter->province);
            }
        }

        /*== RELATIONSHIPS ==*/
        //Include relationships for default
        $includeDefault = [];
        $query->with(array_merge($includeDefault, $include));

        /*== FIELDS ==*/
        $defaultFields = ['id'];
        $query->select(array_merge($defaultFields, $fields));

        //Return request with pagination
        if ($page) {
            $take ? true : $take = 12; //If no specific take, query take 12 for default

            return $query->paginate($take);
        }

        //Return request without pagination
        if (! $page) {
            $take ? $query->take($take) : false; //if request to take a limit

            return $query->get()->sortBy('name');
        }
    }

    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with(['province', 'country', 'translations']);
        } else {//Especific relationships
            $includeDefault = ['translations']; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            //filter by Id
            if (isset($filter->id)) {
                $query->whereIn('id', (array) $filter->id);
            }

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->whereHas('translations', function ($q) use ($filter) {
                        $q->where('name', 'like', '%'.$filter->search.'%');
                    })->orWhere('id', 'like', '%'.$filter->search.'%');
                });
            }

            /**
             * @deprecated Use $filter->countryId or $filter->provinceId instead
             */
            if (isset($filter->country_id)) {
                $query->where('country_id', $filter->country_id);
            }
            if (isset($filter->province_id)) {
                $query->where('province_id', $filter->province_id);
            }

            if (isset($filter->countryId)) {
                $query->where('country_id', $filter->countryId);
            }
            if (isset($filter->provinceId)) {
                $query->where('province_id', $filter->provinceId);
            }

            if (isset($filter->country)) {
                $query->where('country_id', $filter->country);
            }
            if (isset($filter->province)) {
                $query->where('province_id', $filter->province);
            }

            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date; //Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from)) {//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                }
                if (isset($date->to)) {//to a date
                    $query->whereDate($date->field, '<=', $date->to);
                }
            }

            // ORDER
            if (isset($filter->order) && $filter->order) {
                $order = is_array($filter->order) ? $filter->order : [$filter->order];

                foreach ($order as $orderObject) {
                    if (isset($orderObject->field) && isset($orderObject->way)) {
                        if (in_array($orderObject->field, $this->model->translatedAttributes)) {
                            $query->orderByTranslation($orderObject->field, $orderObject->way);
                        } else {
                            $query->orderBy($orderObject->field, $orderObject->way);
                        }
                    }
                }
            }
        }

        $availableCountries = json_decode(setting('ilocations::availableCountries', null, '[]'));
        /*=== SETTINGS ===*/
        if (! empty($availableCountries) && ! isset($params->filter->indexAll)) {
            if (! isset($params->permissions['ilocations.cities.manage']) || (! $params->permissions['ilocations.cities.manage'])) {
                $query->whereHas('country', function ($query) use ($availableCountries) {
                    $query->whereIn('ilocations__countries.iso_2', $availableCountries);
                });
            }
        }

        $availableProvinces = json_decode(setting('ilocations::availableProvinces', null, '[]'));

        /*=== SETTINGS ===*/
        if (! empty($availableProvinces) && ! isset($params->filter->indexAll)) {
            if (! isset($params->permissions['ilocations.cities.manage']) || (! $params->permissions['ilocations.cities.manage'])) {
                $query->whereHas('province', function ($query) use ($availableProvinces) {
                    $query->whereIn('ilocations__provinces.iso_2', $availableProvinces);
                });
            }
        }

        $availableCities = json_decode(setting('ilocations::availableCities', null, '[]'));

        /*=== SETTINGS ===*/
        if (! empty($availableCities) && ! isset($params->filter->indexAll)) {
            if (! isset($params->permissions['ilocations.cities.manage']) || (! $params->permissions['ilocations.cities.manage'])) {
                $query->whereIn('ilocations__cities.id', $availableCities);
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            isset($params->take) && $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['province', 'country', 'translations']);
        } else {//Especific relationships
            $includeDefault = []; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field)) {//Filter by specific field
                $field = $filter->field;
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }

    public function whereByCountry($id)
    {
        return $this->model->where('country_id', $id)->get();
    }
}
