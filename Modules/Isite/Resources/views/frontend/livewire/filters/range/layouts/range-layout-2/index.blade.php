<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">
@if($show)
	<div class="title">
        <a class="item mb-3" data-toggle="collapse" href="#collapse-{{$name}}" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapse-{{$name}}" class="{{$isExpanded ? '' : 'collapsed'}}">

            <h5 class="p-3 border-top border-bottom">
	  			<i class="fa angle float-right" aria-hidden="true"></i>
	  			{{$title}}
	  		</h5>
	  		
		</a>
	</div>

	<div class="content position-relative my-3">

		@include('isite::frontend.partials.preloader')

		<div class="collapse multi-collapse {{$isExpanded ? 'show' : ''}} mb-2" id="collapse-{{$name}}">

			<div class="form-row">
				<div class="col-md-6">
					<label for="selValueMin-{{$name}}">
						{{trans('isite::frontend.filter-range.from')}}:
					</label>
					<input 
						type="number" 
						id="selValueMin-{{$name}}" 
						name="selValueMin-{{$name}}" 
						class="form-control form-control-sm" 
						min="0"
						wire:model.debounce.500ms="selValueMin">
				</div>
				<div class="col-md-6">
					<label for="selValueMax-{{$name}}">
						{{trans('isite::frontend.filter-range.to')}}:
					</label>
					<input 
						type="number" 
						id="selValueMax-{{$name}}" 
						name="selValueMax-{{$name}}"  
						class="form-control form-control-sm" 
						min="0"
						wire:model.debounce.500ms="selValueMax">
				</div>
			</div>

		</div>

	</div>

@endif
</div>


@section('scripts')
@parent

	<script>
	jQuery(document).ready(function($) {
		
		
	});
	</script>

@stop