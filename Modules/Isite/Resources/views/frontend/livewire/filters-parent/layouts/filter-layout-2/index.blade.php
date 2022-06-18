<div class="filters">
	@if(!empty($filters))

		
		<div class="filter-layout-2">
				<div class="row">
					@foreach($filters as $index => $filter)
						@if($filter['status'])
							<div class="{{$filter['classes']}}">
								@livewire("isite::filter-".$filter['type'], $filter, key($index.'-'.$filter['type']))
							</div>
						@endif
					@endforeach
				</div>

				<div class="filter-buttons d-flex justify-content-center my-2">
					@if($showBtnFilter)
						<button wire:click="updateItemsList" id="btnFilter" type="button" class="btnFilter btn btn-primary mx-2">{{$btnFilterLabel ?? trans('isite::frontend.buttons.filter')}}</button>
					@endif
					@if($showBtnClear)
						<button wire:click="clearValuesFilters" id="btnClear" type="button" class="btnClear btn btn-primary mx-2">{{trans('isite::frontend.buttons.clear')}}</button>
					@endif
				</div>

		</div>
		
	@endif
</div>