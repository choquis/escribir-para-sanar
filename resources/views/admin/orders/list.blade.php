<x-admin-layout>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ordenes</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a class="btn btn-sm btn-secondary d-flex align-items-center gap-1" href="{{ route('ordenes.create') }}"
        role="button">
        Añadir
      </a>
    </div>
  </div>
  <div class="col-12 my-3">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"> ID </th>
            <th scope="col"> Estado </th>
            <th scope="col"> Nombre/Correo </th>
            <th scope="col"> Taller </th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $order)
            <tr>
              <td>{{ $order->order_key }}</td>
              <td>{{ $order->status }}</td>
              <td>
                {{ $order->name }}<br />
                {{ $order->email->email }}
              </td>
              <td>
                {{ $order->event->name }}<br />
                {{ $order->event->formattedDate }} {{ $order->event->formattedTime }}
              </td>
              <td>
                <a class="btn btn-sm btn-outline-secondary align-items-center"
                  href="{{ route('ordenes.edit', ['ordene' => $order->id]) }}" role="button">
                  Editar
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  {{ $orders->links() }}
</x-admin-layout>
