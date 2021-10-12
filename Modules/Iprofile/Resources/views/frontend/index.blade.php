@extends('iprofile::frontend.layouts.master')


@section('profileBreadcrumb')
  <x-isite::breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">{{trans('iprofile::frontend.title.profile')}}</li>
  </x-isite::breadcrumb>
@endsection

@section('profileTitle')
  
  @if(isset($user) &&  !empty($user->first_name))
    <span class="text-capitalize">{{trans('iprofile::frontend.title.welcome')}}, {{$user->first_name}}</span>
  @else
    {{trans('iprofile::frontend.title.user name')}}
  @endif
  
  @endsection
@section('profileContent')
  
  @include('iprofile::frontend.partials.edit-fields')

@stop


@section('scripts')
@parent

<script type="text/javascript">

$(document).ready(function () {
  $('#imgProfile').each(function (index) {
    // Find DOM elements under this form-group element
    var $mainImage = $(this).find('#mainImage');
    var $uploadImage = $(this).find("#mainimage");
    var $hiddenImage = $(this).find("#hiddenImage");
    //var $remove = $(this).find("#remove")
    // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
    var options = {
      viewMode: 2,
      checkOrientation: false,
      autoCropArea: 1,
      responsive: true,
      preview: $(this).attr('data-preview'),
      aspectRatio: $(this).attr('data-aspectRatio')
    };


    // Hide 'Remove' button if there is no image saved
    if (!$mainImage.attr('src')) {
      //$remove.hide();
    }
    // Initialise hidden form input in case we submit with no change
    //$.val($mainImage.attr('src'));

    // Only initialize cropper plugin if crop is set to true

    $uploadImage.change(function () {
      var fileReader = new FileReader(),
      files = this.files,
      file;


      if (!files.length) {
        return;
      }
      file = files[0];

      if (/^image\/\w+$/.test(file.type)) {
        fileReader.readAsDataURL(file);
        fileReader.onload = function () {
          $uploadImage.val("");
          $mainImage.attr('src', this.result);
          $hiddenImage.val(this.result);
          $('#hiddenImage').val(this.result);

        };
      } else {
        alert("{{trans('iprofile::frontend.messages.select_image')}}");
      }
    });

  });
});
</script>


@stop
