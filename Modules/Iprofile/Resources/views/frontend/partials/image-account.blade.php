{!! Form::open(['route' => ['iprofile.profile.update', $user->id], 'method' => 'put']) !!}
<div id="imgProfile" class="my-3">

    <!-- imagen -->
        <div class="img-frame mx-auto">
            @if(isset($fields['mainImage']) &&  !empty($fields['mainImage']) && $fields['mainImage']!=null )
            <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{ url($fields['mainImage']).'?'.strtotime(now()) }}" alt="Logo" >
            @else
                <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{$default}}" alt="Logo">
            @endif
        </div>

        <!-- btn -->
        <div class="btn-upload mx-auto">
        
        </div>
        <div class="col-md-12 col-lg-auto text-center pt-2">
    
            <label class="btn btn-danger btn-sm btn-file mb-0 text-white rounded-circle">
                <i class="fa fa-camera"></i>
                <input type="file"
                       accept="image/*"
                       id="mainimage"
                       name="fields[mainImage]"
                       value="mainimage"
                       class="form-control"
                       style="display:none;">
                <input type="hidden"
                       id="hiddenImage"
                       name="fields[mainImage]"
                       required>
            </label>
            <button type="submit"
                class="btn btn-sm btn-primary text-white rounded-pill">
                {{ trans('core::core.button.update') }}
            </button>
        </div>

</div>
{!! Form::close() !!}
