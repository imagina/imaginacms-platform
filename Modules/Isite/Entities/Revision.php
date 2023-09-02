<?php

namespace Modules\Isite\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Revision extends CrudModel
{
    protected $table = 'isite__revisions';

    public $transformer = 'Modules\Isite\Transformers\RevisionTransformer';

    public $repository = 'Modules\Isite\Repositories\RevisionRepository';

    public $requestValidation = [
        'create' => 'Modules\Isite\Http\Requests\CreateRevisionRequest',
        'update' => 'Modules\Isite\Http\Requests\UpdateRevisionRequest',
    ];

    //Instance external/internal events to dispatch with extraData
    public $dispatchesEventsWithBindings = [
        //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
        'created' => [],
        'creating' => [],
        'updated' => [],
        'updating' => [],
        'deleting' => [],
        'deleted' => [],
    ];

    protected $fillable = [
        'revisionable_type',
        'revisionable_id',
        'key',
        'old_value',
        'new_value',
        'created_at',
        'updated_at',
    ];

    protected $revisionFormattedFields = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Instance the revision model
     */
    public static function newModel()
    {
        $model = app('Modules\Isite\Entities\Revision');

        return new $model;
    }

    /**
     * Revisionable.
     *
     * Grab the revision history for the model that is calling
     *
     * @return array revision history
     */
    public function revisionable()
    {
        return $this->morphTo();
    }

    /**
     * Field Name
     *
     * Returns the field that was updated, in the case that it's a foreign key
     * denoted by a suffix of "_id", then "_id" is simply stripped
     *
     * @return string field
     */
    public function fieldName()
    {
        if ($formatted = $this->formatFieldName($this->key)) {
            return $formatted;
        } elseif (strpos($this->key, '_id')) {
            return str_replace('_id', '', $this->key);
        } else {
            return $this->key;
        }
    }

    /**
     * Format field name.
     *
     * Allow overrides for field names.
     */
    private function formatFieldName($key)
    {
        $related_model = $this->getActualClassNameForMorph($this->revisionable_type);
        $related_model = new $related_model;
        $revisionFormattedFieldNames = $related_model->getRevisionFormattedFieldNames();

        if (isset($revisionFormattedFieldNames[$key])) {
            return $revisionFormattedFieldNames[$key];
        }

        return false;
    }

    /**
     * Old Value.
     *
     * Grab the old value of the field, if it was a foreign key
     * attempt to get an identifying name for the model.
     *
     * @return string old value
     */
    public function oldValue()
    {
        return $this->getValue('old');
    }

    /**
     * New Value.
     *
     * Grab the new value of the field, if it was a foreign key
     * attempt to get an identifying name for the model.
     *
     * @return string old value
     */
    public function newValue()
    {
        return $this->getValue('new');
    }

    /**
     * Responsible for actually doing the grunt work for getting the
     * old or new value for the revision.
     *
     * @param  string  $which old or new
     * @return string value
     */
    private function getValue($which = 'new')
    {
        $which_value = $which.'_value';

        // First find the main model that was updated
        $main_model = $this->revisionable_type;
        // Load it, WITH the related model
        if (class_exists($main_model)) {
            $main_model = new $main_model;

            try {
                if ($this->isRelated()) {
                    $related_model = $this->getRelatedModel();

                    // Now we can find out the namespace of of related model
                    if (! method_exists($main_model, $related_model)) {
                        $related_model = Str::camel($related_model); // for cases like published_status_id
                        if (! method_exists($main_model, $related_model)) {
                            throw new \Exception('Relation '.$related_model.' does not exist for '.get_class($main_model));
                        }
                    }
                    $related_class = $main_model->$related_model()->getRelated();

                    // Finally, now that we know the namespace of the related model
                    // we can load it, to find the information we so desire
                    $item = $related_class::find($this->$which_value);

                    if (is_null($this->$which_value) || $this->$which_value == '') {
                        $item = new $related_class;

                        return $item->getRevisionNullString();
                    }
                    if (! $item) {
                        $item = new $related_class;

                        return $this->format($this->key, $item->getRevisionUnknownString());
                    }

                    // Check if model use RevisionableTrait
                    if (method_exists($item, 'identifiableName')) {
                        // see if there's an available mutator
                        $mutator = 'get'.Str::studly($this->key).'Attribute';
                        if (method_exists($item, $mutator)) {
                            return $this->format($item->$mutator($this->key), $item->identifiableName());
                        }

                        return $this->format($this->key, $item->identifiableName());
                    }
                }
            } catch (\Exception $e) {
                // Just a fail-safe, in the case the data setup isn't as expected
                // Nothing to do here.
            }

            // if there was an issue
            // or, if it's a normal value

            $mutator = 'get'.Str::studly($this->key).'Attribute';
            if (method_exists($main_model, $mutator)) {
                return $this->format($this->key, $main_model->$mutator($this->$which_value));
            }
        }

        return $this->format($this->key, $this->$which_value);
    }

    /**
     * Return true if the key is for a related model.
     */
    private function isRelated()
    {
        $isRelated = false;
        $idSuffix = '_id';
        $pos = strrpos($this->key, $idSuffix);

        if ($pos !== false
          && strlen($this->key) - strlen($idSuffix) === $pos
        ) {
            $isRelated = true;
        }

        return $isRelated;
    }

    /**
     * Return the name of the related model.
     */
    private function getRelatedModel()
    {
        $idSuffix = '_id';

        return substr($this->key, 0, strlen($this->key) - strlen($idSuffix));
    }
}
