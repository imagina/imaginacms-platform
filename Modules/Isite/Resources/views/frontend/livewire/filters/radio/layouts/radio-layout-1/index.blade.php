<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">
@if($show)
	<div class="title">
        <a class="item mb-3" data-toggle="collapse" href="#collapse-{{$name}}" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapse-{{$name}}"
        class="{{$isExpanded ? '' : 'collapsed'}}">
			
            <h5 class="p-3 border-top border-bottom">
	  			<i class="fa angle float-right" aria-hidden="true"></i>
	  			{{$title}}
	  		</h5>
	  		
		</a>
	</div>

	<div class="content position-relative my-3">

		@include('isite::frontend.partials.preloader')

		<div class="collapse multi-collapse {{$isExpanded ? 'show' : ''}}" id="collapse-{{$name}}">
			<div class="row">
			  	<div class="col-12">
			  		
			  		<div class="list-{{$name}}">

			  			@foreach($options as $key => $option)
			  				@if($option['status'])
			  				<div class="form-check">
			  					<input class="form-check-input" type="radio" 
			  					value="{{$option['value']}}" 
			  					name="{{$name}}-ptpo{{$key}}" 
			  					id="{{$name}}-ptpo{{$key}}"
			  					wire:model="selectedOption">
								<label class="form-check-label" 
								for="{{$name}}-ptpo{{$key}}">
								    	{{trans($option['title'])}}
								</label>
			  				</div>
			  				@endif
			  			@endforeach

			  		</div>

			  	</div>
		  	</div>

		</div>

	</div>

@endif
</div>