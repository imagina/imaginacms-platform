<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">

{{--
@if($options && count($options)>0)
--}}

	<div class="title">
        <a class="item mb-3" data-toggle="collapse" href="#collapse-{{$name}}" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapse-{{$name}}"
        class="{{$isExpanded ? '' : 'collapsed'}}">
			
            <h5 class="p-3 border-top border-bottom">
	  			<i class="fa angle float-right" aria-hidden="true"></i>
	  			{{$title}}
	  		</h5>
	  		
		</a>
	</div>

	<div class="content position-relative m-3">

		@include('isite::frontend.partials.preloader')

		<div class="collapse multi-collapse {{$isExpanded ? 'show' : ''}}" id="collapse-{{$name}}">
			
			select layout 1

		</div>

	</div>

{{--
@endif
--}}

</div>