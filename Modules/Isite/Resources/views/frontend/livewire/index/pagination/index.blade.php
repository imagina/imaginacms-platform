<div class="row">
	<div class="{{$entityName}}-list-pagination d-flex w-100 px-3 justify-content-end">

		@if($pagination["type"]=="normal")
			{{ $items->links('isite::frontend.livewire.index.pagination.custom') }}
		@endif
		
		@if(($pagination["type"]=="loadMore" || $pagination["type"]=="infiniteScroll"))
		
			<livewire:isite::load-more-button
				:repository="$repository"
				:params="$params"
				:layoutClass="$layoutClass"
				:itemListLayout="$itemListLayout"
				:entityName="$entityName"
				:editLink="$editLink"
				:tooltipEditLink="$tooltipEditLink"
				:itemComponentNamespace="$itemComponentNamespace"
				:itemComponentName="$itemComponentName"
				:itemComponentAttributes="$itemComponentAttributes"
				:pagination="$pagination"
				:itemMainClass="$itemMainClass"
				:itemModal="$itemModal"
			/>
		
		@endif	
						
	</div>
</div>