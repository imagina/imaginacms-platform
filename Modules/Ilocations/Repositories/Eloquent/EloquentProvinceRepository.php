<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ilocations\Repositories\ProvinceRepository;

class EloquentProvinceRepository extends EloquentBaseRepository implements ProvinceRepository
{
    public function index($page, $take, $filter, $include, $fields)
    {
        //Initialize Query
        $query = $this->model->query();
        $query->with('translations');

        /*== FILTER ==*/
        if ($filter) {
            /**
             * @deprecated use $filter->country instead
             */
            if (isset($filter->country_id)) {
                $query->where('country_id', $filter->country_id);
            }
            if (isset($filter->country)) {
                $query->where('country_id', $filter->country);
            }
        }

        /*== RELATIONSHIPS ==*/
        //Include relationships for default
        $includeDefault = [];
        $query->with(array_merge($includeDefault, $include));

        /*== FIELDS ==*/
        $defaultFields = ['id'];

        /*filter by user*/
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
            $query->with(['cities', 'country', 'translations']);
        } else {//Especific relationships
            $includeDefault = ['translations']; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include ?? []);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            if (isset($filter->id)) {
                $query->whereIn('id', (array) $filter->id);
            }

            /**
             * @deprecated Use $filter->countryId
             */
            if (isset($filter->country)) {
                $query->where('country_id', $filter->country);
            }

            if (isset($filter->countryId)) {
                $query->where('country_id', $filter->countryId);
            }

            if (isset($filter->iso2)) {
                $query->whereIn('iso_2', (array) $filter->iso2);
            }

            if (isset($filter->countryCode)) {
                $code = $filter->countryCode;
                $query->whereHas('country', function ($q) use ($code) {
                    $q->where('iso_2', $code);
                });
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

            //New filter by search
            if (isset($filter->search)) {
                $query->where(function ($query) use ($filter) {
                    $query->whereRaw("ilocations__provinces.id IN (SELECT ipt.province_id FROM ilocations__province_translations AS ipt WHERE ipt.locale = '$filter->locale' AND ipt.name LIKE '%$filter->search%')")
                      ->orWhere('ilocations__provinces.id', 'like', '%'.$filter->search.'%')
                      ->orWhere('updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('created_at', 'like', '%'.$filter->search.'%');
                });
            }
        }

        $availableCountries = json_decode(setting('ilocations::availableCountries', null, '[]'));
        /*=== SETTINGS ===*/
        if (! empty($availableCountries) && ! isset($params->filter->indexAll)) {
            if (! isset($params->permissions['ilocations.provinces.manage']) || (! $params->permissions['ilocations.provinces.manage'])) {
                $query->whereHas('country', function ($query) use ($availableCountries) {
                    $query->whereIn('ilocations__countries.iso_2', $availableCountries);
                });
            }
        }

        $availableProvinces = json_decode(setting('ilocations::availableProvinces', null, '[]'));

        /*=== SETTINGS ===*/
        if (! empty($availableProvinces) && ! isset($params->filter->indexAll)) {
            if (! isset($params->permissions['ilocations.provinces.manage']) || (! $params->permissions['ilocations.provinces.manage'])) {
                $query->whereIn('ilocations__provinces.iso_2', $availableProvinces);
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        // dd($query->toSql(),$query->getBindings());
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
            $query->with([]);
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

    public function findByIso2($iso2)
    {
        return $this->model->where('iso_2', $iso2)->first();
    }
}
