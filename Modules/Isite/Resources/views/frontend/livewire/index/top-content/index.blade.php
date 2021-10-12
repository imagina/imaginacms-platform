<div class="top-content mb-2">
	
	@if($showTitle)
		@include('isite::frontend.livewire.index.top-content.custom-titles')
	@endif

	@if($responsiveTopContent['desktop'])

		<div class="options-product-list d-none d-lg-block d-xl-block">

			<div class="row align-items-center">

				{{-- Total Products --}}
				<div class="col-lg-4">
					@include('isite::frontend.livewire.index.top-content.total-items')
				</div>

				{{-- Filter - Order By --}}
				<div class="col-lg-5">

					<livewire:isite::filter-order-by key="filter-order-by"
					:config="config('asgard.'.$moduleName.'.config.orderBy')"/>

				</div>

				{{-- Change Layout --}}
				<div class="col-lg-3">
					@include('isite::frontend.livewire.index.top-content.change-layout') 
				</div>
				
			</div>

		</div>

	@endif

	

	@if($responsiveTopContent['mobile'])
		@include('isite::frontend.livewire.index.top-content.mobile.index')
	@endif
	

</div>