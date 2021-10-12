<div class="option option-{{$option->id}} mb-4 {{$childrenClasses}}">

	<div class="title">
		<a class="item" data-toggle="collapse" href="#collapseOption-{{$option->id}}" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}"
		   aria-controls="collapseOption-{{$option->id}}" class="{{$isExpanded ? '' : 'collapsed'}}">
	  		
	  		<h5 class="p-3 border-top border-bottom">
	  			<i class="fa fa angle float-right" aria-hidden="true"></i>
	  			{{$option->title}}
	  		</h5>
	  		
  		</a>
	</div>

	<div class="content position-relative">
		<div class="collapse {{$isExpanded ? 'show' : ''}}" id="collapseOption-{{$option->id}}">
		  <div class="row">
		  	<div class="col-12">
		  		
		  		<div class="list-option-values">

				  	@foreach($option->children ?? [] as $option)

				  		<div class="mr-2 mb-2 tagBoxs">

                            <input 
                                type="checkbox" 
                                name="{{$name}}{{$option->id}}" 
                                id="{{$name}}{{$option->id}}"
                                value="{{$option->id}}"
                                wire:model="selectedOptions">

                            <label for="{{$name}}{{$option->id}}">
                                <span>{{$option->name ?? $option->title}}</span>
                            </label>

                        </div>

				  	@endforeach
				  	

		  		</div>

		  	</div>
		  </div>
		</div>

	</div>

	

</div>