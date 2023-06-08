<div class="card">
    <div class="card-header bg-secondary">
        <h3 class="font-weight-bold text-white">Información</h3>
    </div>
    <div class="card-body px-4">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Nombre: {{$data['order']->first_name}}</li>
            <li class="list-group-item">Apellido: {{$data['order']->last_name}}</li>
            <li class="list-group-item">Email: {{$data['order']->email}}</li>
            <li class="list-group-item">Total: {{$data['order']->total}}</li>
            <li class="list-group-item">Moneda: {{$data['order']->currency_code}}</li>
        </ul>
    </div>
</div>