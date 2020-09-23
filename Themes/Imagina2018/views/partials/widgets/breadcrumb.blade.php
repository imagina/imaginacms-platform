<div class="bg-breadcrumb">
	<div class="container">
        <div class="row d-flex align-items-center w-100">
            <div class="col-12 d-flex align-items-center">
                <ol class="breadcrumb mb-0  bg-transparent">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">  Inicio</a></li>
                {{$slot}}
                </ol>
            </div>
        </div>
	</div>
</div>
@if(isset($img))
<div class="container bg">
	<div class="container">
		<div class="row justify-content-center">
            <div class="col-12 col-md-10">
                @if(isset($titulo))
                    <h2>{{$titulo}}</h2>
                @endif
                @if(isset($descripcion))
                    {!!$descripcion!!}
                @endif
            </div>
		</div>
	</div>
</div>
@endif
@section('styles')
	@parent
	<style>
	    .bg {
			@if(isset($img))
			    background-image: url({{ $img }});
			@endif
	    }
	</style>
@endsection