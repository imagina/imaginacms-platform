<?php

return [
  'name' => 'Ilocations',

  'relations' => [
    //     'entity'=>[
//        'extension' => function ($self) {
//            return $self->belongsTo(EntityExtension::class, 'foreign_id', 'id')->first();
//        }
//    ]
  ],
  'documentation' => [
    'countries' => "ilocations::cms.documentation.countries",
    'provinces' => "ilocations::cms.documentation.provinces",
    'cities' => "ilocations::cms.documentation.cities",
    'neighborhoods' => "ilocations::cms.documentation.neighborhoods",
    'polygons' => "ilocations::cms.documentation.polygons",
    'geozones' => "ilocations::cms.documentation.geozones",
  ]
];
