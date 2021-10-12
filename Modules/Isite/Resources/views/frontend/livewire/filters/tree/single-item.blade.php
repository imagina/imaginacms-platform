@php($isSelected = !empty($itemSelected) ? $itemSelected->id == $item->id ? true : false : false)

<li class="list-group-item {{$isSelected ? 'item-selected' : ''}} level-{{$level}}">
	
	
	@php($children = $items->where("parent_id",$item->id))
	
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
			<a data-href="{{$item->url}}" style="cursor: pointer" onclick="emit_{{$name}}({{$item->id}},'{{$item->url}}')" class="{{$name}}-link text-href ">
				@php($mediaFiles = $item->mediaFiles())
				@if($withIcon)
					<img class="item-icon filter" src="{{$mediaFiles->iconimage->path}}">
				@endif
				<span class="{{$withIcon ? 'span-with-icon' : 'span-without-icon'}}" title="{{$item->title}}">{{$item->title}}</span>
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
				@php($mediaFiles = $item->mediaFiles())
				@if($withIcon)
					<img class="item-icon filter" src="{{$mediaFiles->iconimage->path}}">
				@endif
				<span class="{{$withIcon ? 'span-with-icon' : 'span-without-icon'}}" title="{{$item->title}}">{{$item->title}}</span>
			</a>
			<a data-href="{{$item->url}}" style="cursor: pointer" onclick="emit_{{$name}}({{$item->id}},'{{$item->url}}')" class="{{$name}}-link icon-href float-right">
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
		<a  data-href="{{$item->url}}" style="cursor: pointer" onclick="emit_{{$name}}({{$item->id}},'{{$item->url}}')" class="{{$name}}-link link-childless d-block {{$isSelected && $children->isEmpty() ? 'font-weight-bold' : ''}}">
			@php($mediaFiles = $item->mediaFiles())
			@if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg"))
				<img class="item-icon filter" src="{{$mediaFiles->iconimage->path}}">
			@endif
			<span title="{{$item->title}}">{{$item->title}}</span>
		</a>
	@endif

</li>

