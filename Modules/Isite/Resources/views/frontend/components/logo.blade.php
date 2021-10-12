@if(!empty($logo))
  <div class="relative-position">
    <x-isite::edit-link link="/iadmin/#/site/index/?settingName={{$zone}}"
                        :tooltip="trans('isite::common.editLink.tooltipLogo')"/>

    <x-media::single-image :alt="setting('core::site-name')" :title="setting('core::site-name')"
                           :url="$to" :isMedia="true" :zone="$zone" :imgClasses="$imgClasses"
                           :mediaFiles="$logo->mediaFiles()"/>
  </div>
@endif

