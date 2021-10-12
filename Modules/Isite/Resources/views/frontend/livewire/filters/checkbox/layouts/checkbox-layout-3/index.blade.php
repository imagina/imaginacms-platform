<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">

	<div class="content position-relative {{$wrapperClasses}}">
		@include('isite::frontend.partials.preloader')
		
		@if($options && count($options)>0)
			@foreach($options->where("parent_id",0) as $key => $option)
				
				@include('isite::frontend.livewire.filters.checkbox.layouts.checkbox-layout-3.option',['option'=> $option])
				
			@endforeach
		@endif
	</div>

</div>