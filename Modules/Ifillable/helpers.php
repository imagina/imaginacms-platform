<?php

//Return the list of the ignored fields
if (! function_exists('getIgnoredFields')) {
    function getIgnoredFields()
    {
        return array_merge(
            [//Ever ignore this fields
                'id', 'organization_id',
                'created_at', 'created_by',
                'updated_at', 'updated_by',
                'deleted_at', 'deleted_by',
                'media_files', 'medias_single',
            ],
            //Ignore any available locale as field
            array_keys(config('available-locales'))
        );
    }
}
