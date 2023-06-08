
<section id="idocsDocumentItemLayout1" class="idocs-document-item-layout">

  <div class="row item">
    <div class="col-12 col-md-6 title-description">
      <h3 class="title">{{$item->title}}</h3>
      <span class="category-title">{{$item->category->title}}</span>
      <div class="description">
        {!!$item->description!!}
      </div>
      
    </div>
    <div class="col-6 col-md-2 size">
      <span class=" d-sm-block d-md-none d-lg-none"> {{trans('idocs::documents.form.size')}}</span>
      {{round($item->file->size /1000000,2)}} mb
    </div>

    <div class="col-6 col-md-2 downloaded">
      <span class="  d-sm-block d-md-none d-lg-none"> {{trans('idocs::documents.form.downloads')}}</span>
      {{$item->tracking->downloaded}}
    </div>
    <div class="col-12 col-md-2 download">
      <span class=" d-sm-block d-md-none d-lg-none"> {{trans('idocs::documents.form.download')}}</span>
      <a class="ml-3 download-link" href="{{$item->public_url}}" target="_blank">
        <i class="fa fa-cloud-download" aria-hidden="true"></i>
      </a>
    </div>
  </div>
  
</section>
