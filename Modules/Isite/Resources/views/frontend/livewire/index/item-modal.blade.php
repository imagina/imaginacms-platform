<div class="item-modal">

	<div wire:ignore.self id="{{$idModal}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="{{$idModal}}Label" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">

	    <div class="modal-content">
	    	
	    	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		    </div>

		    <div class="modal-body"></div>

	    </div>
	    
	  </div>
	</div>

	@include('isite::frontend.partials.preloader-all-page')
	
</div>

@section('scripts-owl')
	@parent
	<script type="text/javascript">
		
		window.addEventListener('item-load-modal-content-{{$idModal}}', event => {
			var previouslyUrl =''
			//console.warn("CARGA MODAL {{$idModal}} - "+event.detail.idModalNew)
			
			$('#'+event.detail.idModalNew).modal('show');
			$("#"+event.detail.idModalNew+" .modal-body").append(event.detail.newHtml);
			
			if(event.detail.itemUrl){
				previouslyUrl = window.location.href;
				window.history.pushState("", "", event.detail.itemUrl)
			}
			
			$('#{{$idModal}}').on('hidden.bs.modal', (e) => {
				console.warn("pasoo",previouslyUrl)
				window.history.pushState("", "", previouslyUrl)
			})
			
		});
	</script>
	
	@stop