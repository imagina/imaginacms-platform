{{--@php--}}
{{--  $otherplaces = get_places(['exclude' => ['places' => $place->id]]);--}}
{{--@endphp--}}
<div class="other-places">
  <div class="col-12 pb-5">
    <hr class="my-5">
    <x-isite::carousel.owl-carousel
      id="otherPlaces"
      repository="Modules\Iplaces\Repositories\PlaceRepository"
      :params="['take' => 30]"
      :margin="30"
      :loops="true"
      :dots="false"
      :nav="false"
      :title="trans('iplaces::places.title.other-places')"
      mediaImage="mainimage"
      :autoplay="true"
      :withViewMoreButton="false"
      :withSummary="false"
      :responsive="[0 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]"/>
  </div>
</div>



















