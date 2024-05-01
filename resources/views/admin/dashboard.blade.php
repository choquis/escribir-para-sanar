<x-admin-layout>
  <div class="col-md-auto mx-auto py-3 ">
    <!-- terminar sesion -->
    <form class="row" method="POST" action="{{ route('logout') }}">
      @csrf
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary py-2 px-4">Cerrar sesión</button>
      </div>
    </form>
    <hr>

    <p class="h2"> Ultimos pagos </p>
    <div class="col-12 my-3">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col"> ID </th>
              <th scope="col"> Fecha </th>
              <th scope="col"> Pago </th>
              <th scope="col"> Quien pago </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($last_payments as $payment)
              <tr>
                <td>{{ $payment->order_key }}</td>
                <td>{{ $payment->response['purchase_units'][0]['payments']['captures'][0]['create_time'] }}</td>
                <td>{{ $payment->response['purchase_units'][0]['payments']['captures'][0]['amount']['value'] }}</td>
                <td>
                  {{ $payment->response['payment_source']['paypal']['name']['surname'] .
                      ' ' .
                      $payment->response['payment_source']['paypal']['name']['given_name'] }}
                  <br />
                  {{ $payment->response['payment_source']['paypal']['email_address'] }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <hr>

    <p class="h2"> Siguientes talleres </p>
    <div class="col-12 my-3">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col"> Nombre </th>
              <th scope="col"> Fecha </th>
              <th scope="col"> Inscritos </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($next_events as $event)
              <tr>
                <td>
                  {{ $event->name }}
                </td>
                <td>
                  {{ $event->formattedDate }} {{ $event->formattedTime }}
                </td>
                <td>{{ $event->orders_count ?? 0 }} / {{ $event->cap }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</x-admin-layout>
