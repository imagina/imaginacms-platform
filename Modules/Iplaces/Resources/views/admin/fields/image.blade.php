<div id="image">
    <div class="bgimg-profile">

        @if(isset($entity->mainimage)&&!empty($entity->mainimage))
            <img id="mainImage"
                 class="image profile-user-img  img-responsive"
                 width="100%"
                 src="{{$entity->mainimage}}'?v='{{str_random(4)}}"/>
        @else
            <img id="mainImage"
                 class="image profile-user-img img-responsive"
                 width="100%"
                 src="{{url('modules/iplaces/img/default.jpg')}}"/>
        @endif
    </div>
    <div class="btn-group bt-upload">
        <label class="btn btn-primary btn-file">
            <i class="fa fa-picture-o"></i> {{trans('iplaces::places.form.select photo')}}
            <input
                    type="file" accept="image/*" id="mainimage"
                    name="mainimage"
                    value="mainimage"
                    class="form-control" style="display:none;">
            <input
                    type="hidden"
                    id="hiddenImage"
                    name="mainimage"
                    value="{{$entity->options->mainimage??''}}"
                    required>
        </label>
    </div>
</div>

@push('js-stack')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#image').each(function (index) {
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
                        alert("Por favor seleccione una imagen.");
                    }
                });

            });
        });
    </script>

    <style>
        .profile-user-img {
            margin: 0 auto;
            width: 100px;
            padding: 3px;
            /* border: 3px solid #d2d6de; */
            font-size: 118px;
        }

        .carousel-inner > .item > a > img, .carousel-inner > .item > img, .img-responsive, .thumbnail a > img, .thumbnail > img {
            display: flex;
            /* max-width: 105%; */
            height: auto;
            width: auto;
        }
    </style>


@endpush
