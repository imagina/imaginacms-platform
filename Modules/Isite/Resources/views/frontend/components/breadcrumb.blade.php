<!-- Schema.org to the breadcrumb -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
    @php
    $dom = new DOMDocument;
    $dom->loadHTML($slot);
    $position=1;
    foreach ($dom->getElementsByTagName('a') as $a) {
  @endphp
  {
         "@type": "ListItem",
         "position": "{{$position}}",
           "name": "{{trim(strip_tags($a->nodeValue))}}",
           "item": "{{$a->getAttribute('href')}}"
       },
@php
    $position++;
}
$lis = $dom->getElementsByTagName('li')->item($dom->getElementsByTagName('li')->length-1 );
  
  @endphp
  {
      "@type": "ListItem",
      "position": "{{$position}}",
            "name": "{{trim(strip_tags($lis->nodeValue))}}",
            "item": "{{Request::url()}}"
  }
]
}
</script>

<section id="breadcrumbSection">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-5 pl-0">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('isite::common.menu.home')}}</a></li>
            
            {{ $slot }}
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
