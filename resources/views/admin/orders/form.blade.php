<x-admin-layout>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
      @if (isset($order))
        Modificar orden
      @else
        Añadir orden
      @endif
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
        href="{{ session('order:index', route('ordenes.index')) }}" role="button">
        Cancelar
      </a>
    </div>
  </div>
  @error('invalid')
    <div class="alert alert-warning alert-dismissible" role="alert">
      <div> {{ $message }} </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror
  <form class="col-12 my-3" method="POST"
    action="{{ isset($order) ? route('ordenes.update', ['ordene' => $order->id]) : route('ordenes.store') }}">
    @csrf
    @isset($order)
      @method('PUT')
    @endisset

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="type" class="form-label">Tipo</label>
      <input type="text" class="form-control" id="type" name="type"
        value="{{ isset($order) ? old('type', $order->type) : old('type') }}" readonly>
      @error('type')
        <span class="text-danger">
          {{ $errors->first('type') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="order_key" class="form-label">ID</label>
      <input type="text" class="form-control" id="order_key" name="order_key"
        value="{{ isset($order) ? old('order_key', $order->order_key) : old('order_key') }}" readonly>
      @error('order_key')
        <span class="text-danger">
          {{ $errors->first('order_key') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    @php
      $statusOptions = ['CREATED', 'SAVED', 'APPROVED', 'VOIDED', 'COMPLETED', 'PAYER_ACTION_REQUIRED'];
    @endphp

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="status" class="form-label">Estado</label>
      <select name="status" class="form-select" aria-label="Default select example" readonly>
        @foreach ($statusOptions as $op)
          <option value="{{ $op }}" @selected(isset($order) && old('status', $order->status) == $op)>
            {{ $op }}
          </option>
        @endforeach
      </select>
      @error('status')
        <span class="text-danger">
          {{ $errors->first('status') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3 d-flex flex-column">
      <label for="status" class="form-label">Detalle de la orden</label>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#orderModal">
          Ver
        </button>
      </div>
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3 d-flex flex-column">
      <label for="status" class="form-label">Taller</label>
      <input type="text" class="form-control mb-3" id="event_name" name="event_name"
        value="{{ isset($order) ? old('event_name', $order->event->name) : old('event_name') }}" readonly>
      <input type="text" class="form-control d-none" id="event_id" name="event_id"
        value="{{ isset($order) ? old('event_id', $order->event->id) : old('event_id') }}" readonly>
      @error('event_id')
        <span class="text-danger">
          {{ $errors->first('event_id') }}
        </span>
      @enderror
      <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
        <button id="openEventModal" type="button" class="btn btn-outline-secondary">
          Seleccionar taller
        </button>
      </div>
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3 d-flex flex-column">
      <label for="status" class="form-label">Correo</label>
      <input type="text" class="form-control mb-3" id="email" name="email"
        value="{{ isset($order) ? old('email', $order->email->email) : old('email') }}" readonly>
      <input type="text" class="form-control d-none" id="email_id" name="email_id"
        value="{{ isset($order) ? old('email_id', $order->email->id) : old('email_id') }}" readonly>
      @error('email_id')
        <span class="text-danger">
          {{ $errors->first('email_id') }}
        </span>
      @enderror
      <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
        <button id="openEmailModal" type="button" class="btn btn-outline-secondary">
          Seleccionar correo
        </button>
      </div>
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="name" class="form-label">Nombre</label>
      <input type="text" class="form-control" id="name" name="name"
        value="{{ isset($order) ? old('name', $order->name) : old('name') }}">
      @error('name')
        <span class="text-danger">
          {{ $errors->first('name') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-12 mt-5 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary py-2 px-4">
        {{ isset($order) ? 'Actualizar' : 'Guardar' }}
      </button>
    </div>
  </form>

  <div id="orderModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalle de la orden</h5> <br />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <pre>{{ isset($order) ? print_r($order->response, true) : 'Nada que mostrar' }}</pre>
        </div>
      </div>
    </div>
  </div>

  <div id="eventModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buscar taller</h5> <br />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input id="searchEventName" type="text" class="form-control" placeholder="Buscar"
              aria-label="searchEventName" aria-describedby="searchEventName">
          </div>
          <div class="col-12 d-flex justify-content-center spinner-container d-none">
            <div class="spinner-border text-secondary" role="status">
              <span class="visually-hidden">Buscando...</span>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-center spinner-container">
            <select id="eventList" class="form-select" style="min-height: 30vh;" size="3"
              aria-label="eventList">
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button id="eventSelection" type="button" class="btn btn-primary">Seleccionar</button>
        </div>
      </div>
    </div>
  </div>

  <div id="emailModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buscar correo</h5> <br />
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input id="searchEmailName" type="text" class="form-control" placeholder="Buscar"
              aria-label="searchEmailName" aria-describedby="searchEmailName">
          </div>
          <div class="col-12 d-flex justify-content-center spinner-container d-none">
            <div class="spinner-border text-secondary" role="status">
              <span class="visually-hidden">Buscando...</span>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-center spinner-container">
            <select id="emailList" class="form-select" style="min-height: 30vh;" size="3"
              aria-label="emailList">
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button id="emailSelection" type="button" class="btn btn-primary">Seleccionar</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="{{ asset('js/orders.js') }}"></script>
  @endpush
</x-admin-layout>
