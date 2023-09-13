<?php

return [
    /*
    |--------------------------------------------------------------------------
    | These are the core modules that should NOT be disabled under any circumstance
    |--------------------------------------------------------------------------
    */
    'CoreModules' => [
        'core',
        'isite',
        'iprofile',
        'dashboard',
        'user',
        'workshop',
        'setting',
        'menu',
        'media',
        'tag',
        'page',
        'translation',
        'notification',
        'icustom',
        'ischedulable',
        'ifillable',
        'ihelpers',
        'iforms',
        'ibuilder',
        'ilocations',
        'igamification',
      
    ],

    /*
|--------------------------------------------------------------------------
| These are the domains locales configs for activate specific locale to a list of domains for each locale
| there can't be a domain in multiple locales, the code will be assign the first match founded
|--------------------------------------------------------------------------
*/
    'domainsLocalesProd' => [
        'en' => [
            // "www.imaginadw.com",

        ],
        'es' => [
            // "www.imaginacolombia.com"
        ],
    ],

    'domainsLocalesLocal' => [
        'en' => [
            //"imaginadw.ozonohosting.com",

        ],
        'es' => [
            //"imaginacolombia.ozonohosting.com"
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Load additional view namespaces for a module
    |--------------------------------------------------------------------------
    | You can specify place from which you would like to use module views.
    | You can use any combination, but generally it's advisable to add only one,
    | extra view namespace.
    | By default every extra namespace will be set to false.
    */
    'useViewNamespaces' => [
        // Read module views from /Themes/<backend-theme-name>/views/modules/<module-name>
        'backend-theme' => false,
        // Read module views from /Themes/<frontend-theme-name>/views/modules/<module-name>
        'frontend-theme' => false,
        // Read module views from /resources/views/asgard/<module-name>
        'resources' => false,
    ],

    'userstamping' => true,
];
