@php($isSelected = !empty($itemSelected) ? $itemSelected->id == $item->id ? true : false : false)

<li class="list-group-item {{$isSelected ? 'item-selected' : ''}} level-{{$level}}">
	
	
	@php($children = $item->children)

	@php($expanded = false)

	@php($slug = $item->slug)

	@foreach($breadcrumb as $itemBreadcrumb)
		@if($itemBreadcrumb->id == $item->id)
			@php($expanded = true)
		@endif
	@endforeach
	@php($mediaFiles = $item->mediaFiles())
	@php(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg") ? $withIcon = true : $withIcon = false)

	@if($children->isNotEmpty())
		<div class="link-desktop d-none d-md-block {{$isSelected && $children ? 'font-weight-bold' : ''}}">
			<a href="{{$item->url}}" style="cursor: pointer" onclick="event.preventDefault(); emit_{{$name}}({{$item->id}},'{{$item->url}}')" class="{{$name}}-link text-href ">

				@if($withIcon)
					<img class="item-icon filter" src="{{$mediaFiles->iconimage->path}}">
				@endif
				<span class="{{$withIcon ? 'span-with-icon' : 'span-without-icon'}}" title="{{$item->title}}">{{$item->title}}-{{$item->id}}</span>
			</a>
			<a class="icon-collapsable" data-toggle="collapse" role="button"
				 href="#multiCollapse-{{$slug}}" aria-expanded="{{$isSelected && $children ? 'true' : 'false'}}"
				 aria-controls="multiCollapse-{{$slug}}">
				<i class="fa angle"></i>
			</a>
		</div>
		<div class="link-movil d-block d-md-none {{$isSelected && $children ? 'font-weight-bold' : ''}}">
			<a class="text-collapsable" data-toggle="collapse" role="button"
				 href="#multiCollapse-{{$slug}}" aria-expanded="{{$isSelected && $children ? 'true' : 'false'}}"
				 aria-controls="multiCollapse-{{$slug}}">

				@if($withIcon)
					<img class="item-icon filter" src="{{$mediaFiles->iconimage->path}}">
				@endif
				<span class="{{$withIcon ? 'span-with-icon' : 'span-without-icon'}}" title="{{$item->title}}">{{$item->title}}-{{$item->id}}</span>
			</a>
			<a href="{{$item->url}}" style="cursor: pointer" onclick="event.preventDefault(); emit_{{$name}}({{$item->id}},'{{$item->url}}')" class="{{$name}}-link icon-href float-right">
				<i class="fa fa-external-link"></i>
			</a>
		</div>
		<div class="collapse multi-collapse mt-2 {{$expanded ? 'show' : ''}}" id="multiCollapse-{{$slug}}">
			<ul class="list-group list-group-flush">
				@foreach($children as $item)
					@include('isite::frontend.livewire.filters.tree.single-item',["level" => $level+1,"itemId" => $item->id])
				@endforeach
			</ul>
		</div>
	@else
		<a  href="{{$item->url}}" style="cursor: pointer" onclick="event.preventDefault(); emit_{{$name}}({{$item->id}},'{{$item->url}}')" class="{{$name}}-link link-childless d-block {{$isSelected && $children->isEmpty() ? 'font-weight-bold' : ''}}">

			@if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg"))
				<img class="item-icon filter" src="{{$mediaFiles->iconimage->path}}">
			@endif
			<span title="{{$item->title}}">{{$item->title}}-{{$item->id}}</span>
		</a>
	@endif

</li>

