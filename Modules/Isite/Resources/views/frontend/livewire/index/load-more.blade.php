<div>
	
	@include("isite::frontend.livewire.index.partials.items",["items"=>$items])

	@if($pagination["type"]=="loadMore" && $items->hasMorePages())
		
		<livewire:isite::load-more-button
			:repository="$repository"
			:params="$params"
			:layoutClass="$layoutClass"
			:editLink="$editLink"
			:tooltipEditLink="$tooltipEditLink"
			:entityName="$entityName"
			:itemComponentNamespace="$itemComponentNamespace"
			:itemComponentName="$itemComponentName"
			:itemComponentAttributes="$itemComponentAttributes"
			:pagination="$pagination"
		/>
		
	@endif	

</div>	