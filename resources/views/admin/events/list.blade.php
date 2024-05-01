<x-admin-layout>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Talleres</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a class="btn btn-sm btn-secondary d-flex align-items-center gap-1" href="{{ route('eventos.create') }}"
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
            <th scope="col"> Nombre </th>
            <th scope="col"> Fecha </th>
            <th scope="col"> Capacidad </th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($events as $event)
            <tr>
              <td>{{ $event->name }}</td>
              <td>{{ $event->formattedDate }} {{ $event->formattedTime }}</td>
              <td>{{ $event->orders_count ?? 0 }} / {{ $event->cap }}</td>
              <td>
                <a class="btn btn-sm btn-outline-secondary align-items-center"
                  href="{{ route('eventos.edit', ['evento' => $event->id]) }}" role="button">
                  Editar
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  {{ $events->links() }}
</x-admin-layout>
