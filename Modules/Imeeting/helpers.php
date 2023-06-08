<?php

/**
* Get Provider Configuration
* @return collection
*/

if (!function_exists('imeetingGetProviderConfiguration')) {

        function imeetingGetProviderConfiguration($providerName){

                $attribute = array('name' => $providerName);
                $provider = app("Modules\Imeeting\Repositories\ProviderRepository")->findByAttributes($attribute); 
        
                return $provider;

        }

}
