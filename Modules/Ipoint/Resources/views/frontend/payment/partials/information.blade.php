<div class="order-infor">
  <table class="table">
    <tbody>
      <tr>
        <th scope="row">Email:</th>
        <td>{{$order->email}}</td>
      </tr>

      <tr>
        <th scope="row">Nombres:</th>
        <td>{{$order->first_name}}</td>
      </tr>

      <tr>
        <th scope="row">Apellidos:</th>
        <td>{{$order->last_name}}</td>
      </tr>

      <tr>
        <th scope="row">Order ID:</th>
        <td>{{$order->id}}</td>
      </tr>

      <tr>
        <th scope="row">Total de la Orden:</th>
        <td>{{$order->total}}</td>
      </tr>

      
      <tr>
        <th scope="row">Puntos necesarios para pagar la orden:</th>
        <td>{{$resultValidate['pointsItems']}}</td>
      </tr>

      <tr>
        <th scope="row">Puntos Disponibles:</th>
        <td>{{$resultValidate['pointsUser']}}</td>
      </tr>
      
      
    </tbody>
  </table>
</div>