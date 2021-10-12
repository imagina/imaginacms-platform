<div id="multilanglayout3" class="multilang">

    <form action="">
        <div class="selectbox">
            <div class="select" id="select">
                <div class="contenido-select">
                    <h4 class="titulo">Selecciona tu Idioma</h4>
                </div>
                <i class="fas fa-angle-down" aria-hidden="true"></i>
      
            </div>
      
            <div class="opciones" id="opciones">
            
      <a href="#" class="opcion"value="es">
        
                    <div class="contenido-opcion">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPK_QCwe-IppY2_cLHpqbDoorQga-wVE4TUw&usqp=CAU" alt="">
                        <div class="textos">
                            <h4 class="titulo">Spanish</h4>
                        </div>
                    </div>
        
                </a>
      <hr>
                <a href="#" class="opcion"value="en">
                    <div class="contenido-opcion">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/83/Flag_of_the_United_Kingdom_%283-5%29.svg/1200px-Flag_of_the_United_Kingdom_%283-5%29.svg.png" alt="">
                        <div class="textos">
                            <h4 class="titulo">English</h4>
                        </div>
                    </div>
                </a>
      <hr>
                <a href="#" class="opcion">
                    <div class="contenido-opcion" value="al">
                        <img src="https://media.istockphoto.com/vectors/germany-flag-vector-id166012239?k=20&m=166012239&s=612x612&w=0&h=yA820ncZYE7wNzPWlwuA1gFynXokkO2qdDVl8SXJx1M=" alt="">
                        <div class="textos">
                            <h4 class="titulo">German</h4>
                        </div>
                    </div>
        
                </a>
      <hr>
                <a href="#" class="opcion">
        
                    <div class="contenido-opcion" value="ca">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Flag_of_Catalonia.svg/1200px-Flag_of_Catalonia.svg.png" alt="">
                        <div class="textos">
                            <h4 class="titulo">Catalan</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <input type="hidden" name="pais" id="inputSelect" value="">
    </form>

</div>

@section('scripts')
    @parent
    <script type="text/javascript">
       const select = document.querySelector('#select');
const opciones = document.querySelector('#opciones');
const contenidoSelect = document.querySelector('#select .contenido-select');
const hiddenInput = document.querySelector('#inputSelect');

document.querySelectorAll('#opciones > .opcion').forEach((opcion) => {
	opcion.addEventListener('click', (e) => {
		e.preventDefault();
		contenidoSelect.innerHTML = e.currentTarget.innerHTML;
		select.classList.toggle('active');
		opciones.classList.toggle('active');
		hiddenInput.value = e.currentTarget.querySelector('.titulo').innerText;
	});
});

select.addEventListener('click', () => {
	select.classList.toggle('active');
	opciones.classList.toggle('active');
});
    </script>
@stop