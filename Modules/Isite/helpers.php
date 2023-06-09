<?php

if (! function_exists('alternate')) {
    function alternate($model)
    {
        $alternate = [];
        $supportedLocales = config('laravellocalization.supportedLocales');

        if (count($supportedLocales) == 1) {
            return $alternate;
        }

        $translations = $model->getTranslationsArray() ?? [];

        foreach ($translations as $locale => $data) {
            if (isset($data['slug'])) {
                $href = \URL::to('/'.$locale.'/'.$data['slug']);
                $alternate[$locale] = [
                    'slug' => $data['slug'],
                    'link' => "<link rel='alternate' hreflang='$locale' href='$href'>",
                ];
            }
        }

        return $alternate;
    }
}

if (! function_exists('getEditLink')) {
    function getEditLink($repository = null, $componentName = null)
    {
        switch ($repository) {
            case 'Modules\Iad\Repositories\AdRepository':
                $editLink = '/iadmin/#/ad/ads/update/';
                $tooltipEditLink = trans('isite::common.editLink.tooltipAd');
                break;
            case 'Modules\Icommerce\Repositories\ProductRepository':
                $editLink = '/iadmin/#/ecommerce/products?edit=';
                $tooltipEditLink = trans('isite::common.editLink.tooltipProduct');
                break;
            case 'Modules\Icommerce\Repositories\CategoryRepository':
                $editLink = '/iadmin/#/ecommerce/product-categories?edit=';
                $tooltipEditLink = trans('isite::common.editLink.tooltipCategory');
                break;
            case 'Modules\Icommerce\Repositories\ManufacturerRepository':
                $editLink = '/iadmin/#/ecommerce/manufacturers?edit=';
                $tooltipEditLink = trans('isite::common.editLink.tooltipManufacturer');
                break;
            case 'Modules\Iblog\Repositories\PostRepository':
                $editLink = '/iadmin/#/blog/posts/index?edit=';
                $tooltipEditLink = trans('isite::common.editLink.tooltipPost');
                break;
            case 'Modules\Iblog\Repositories\CategoryRepository':
                $editLink = '/iadmin/#/blog/categories/index?edit=';
                $tooltipEditLink = trans('isite::common.editLink.tooltipCategory');
                break;
            case 'Modules\Slider\Repositories\SlideRepository':
            case 'Modules\Slider\Repositories\SlideApiRepository':
                $editLink = '/iadmin/#/slider/show/';
                $tooltipEditLink = trans('isite::common.editLink.tooltipSlide');
                break;
            case 'Modules\Iplaces\Repositories\PlaceRepository':
                $editLink = '/iadmin/#/iplaces/places/index?edit=';
                $tooltipEditLink = trans('isite::common.editLink.tooltipPlace');
                break;
            case 'Modules\Iplaces\Repositories\CategoryRepository':
                $editLink = '/iadmin/#/iplaces/categories/index?edit=';
                $tooltipEditLink = trans('isite::common.editLink.tooltipCategory');
                break;
            default:
                switch ($componentName) {
                    case 'logo':
                        $editLink = '/iadmin/#/iplaces/places/index?edit=';
                        $tooltipEditLink = trans('isite::common.editLink.tooltipLogo');
                        break;

                    default:
                        $editLink = '/iadmin/#';
                        $tooltipEditLink = trans('isite::common.editLink.tooltip');
                        break;
                }
                break;
        }

        return [$editLink, $tooltipEditLink];
    }
}

if (! function_exists('isiteFormatMoney')) {
    function isiteFormatMoney($value, $showCurrencyCode = false)
    {
        $format = (object) (Config::get('asgard.isite.config.isiteFormatMoney') ?? [
            'decimals' => 0,
            'decimal_separator' => '',
            'thousands_separator' => '.',
        ]);

        $numberFormat = number_format($value, $format->decimals, $format->decimal_separator, $format->thousands_separator);

        if (is_module_enabled('Icommerce')) {
            if ($showCurrencyCode) {
                $currency = currentCurrency();
                $numberFormat = $numberFormat.' '.$currency->code;
            }
        }

        return $numberFormat;
    }
}

if (! function_exists('generatePassword')) {
    function generatePassword($length = 12, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = [];
        if (strpos($available_sets, 'l') !== false) {
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        }
        if (strpos($available_sets, 'u') !== false) {
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        }
        if (strpos($available_sets, 'd') !== false) {
            $sets[] = '23456789';
        }
        if (strpos($available_sets, 's') !== false) {
            $sets[] = '!@#$%&*?/_-+';
        }
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }
        $password = str_shuffle($password);
        if (! $add_dashes) {
            return $password;
        }
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len).'-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;

        return $dash_str;
    }
}

if (! function_exists('isMobileDevice')) {
    function isMobileDevice()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER['HTTP_USER_AGENT']);
    }
}

/*
* Locale in url - SET
*/
if (! function_exists('setLocaleInUrl')) {
    function setLocaleInUrl($locale)
    {
        //return LaravelLocalization::getLocalizedURL($locale);
        return url()->current().'?'.http_build_query(['lang' => $locale]);
    }
}

/*
* Locale in url - GET
*/
if (! function_exists('validateLocaleFromUrl')) {
    function validateLocaleFromUrl($request, $params = null)
    {
        $locale = locale();

        if ($request->has('lang') && $request->lang != $locale) {
            $locale = $request->lang;

            //Casos: Home
            if (! isset($params)) {
                $newUrl = url($locale);
            }

            //Casos: Index Icommerce (Store es traduccion)
            if (isset($params['fixedTrans'])) {
                $newUrl = url($locale).'/'.trans($params['fixedTrans'], [], $locale);
            }

            //Casos: Pages,Iblog (Index Categoria), Icommerce(Index Categoria)
            if (isset($params['entity'])) {
                $newUrl = $params['entity']->getUrlAttribute($locale);
            }

            // vars to reedirect
            $result['reedirect'] = true;
            $result['url'] = $newUrl;

            // Sto no funco para las paginas
            /*
            if(isset($newUrl))
              header("Location: ".$newUrl);
            */
        }

        $result['locale'] = $locale;

        return $result;
    }
}

/**
 * Helper to show infor connection in Log or others
 */
if (! function_exists('showDataConnection')) {
    function showDataConnection($inLog = true)
    {
        $dbname = \DB::connection()->getDatabaseName();
        if ($inLog) {
            \Log::info('Isite: Helper|ShowDataConnection|DB: '.$dbname);
        }
    }
}
