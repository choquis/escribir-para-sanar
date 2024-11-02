<x-admin-layout>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Correos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a class="btn btn-sm btn-secondary d-flex align-items-center gap-1 me-3" href="{{ route('correos.create') }}"
        role="button">
        Descargar csv
      </a>
      <a class="btn btn-sm btn-secondary d-flex align-items-center gap-1" href="{{ route('correos.create') }}"
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
            <th scope="col"> Correo </th>
            <th scope="col"> Suscrito </th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($emails as $email)
            <tr>
              <td>{{ $email->name }}</td>
              <td>{{ $email->email }}</td>
              <td>{{ $email->newsletter ? 'Sí' : 'No' }}</td>
              <td>
                <a class="btn btn-sm btn-outline-secondary align-items-center"
                  href="{{ route('correos.edit', ['correo' => $email->id]) }}" role="button">
                  Editar
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  {{ $emails->links() }}
</x-admin-layout>
