<x-admin-layout>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2">
      @if (isset($event))
        Modificar taller
      @else
        Añadir taller
      @endif
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
        href="{{ session('event:index', route('eventos.index')) }}" role="button">
        Cancelar
      </a>
    </div>
  </div>
  <hr class="my-3">
  @error('invalid')
    <div class="alert alert-warning alert-dismissible" role="alert">
      <div> {{ $message }} </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror
  <form class="col-12 my-3" method="POST"
    action="{{ isset($event) ? route('eventos.update', ['evento' => $event->id]) : route('eventos.store') }}">
    @csrf
    @isset($event)
      @method('PUT')
    @endisset
    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="name" class="form-label">Nombre</label>
      <input type="text" class="form-control" id="name" name="name"
        value="{{ isset($event) ? old('name', $event->name) : old('name') }}">
      @error('name')
        <span class="text-danger">
          {{ $errors->first('name') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="description" class="form-label">Fechas (en texto)</label>
      <input type="text" class="form-control" id="description" name="description"
        value="{{ isset($event) ? old('description', $event->description) : old('description') }}">
      @error('description')
        <span class="text-danger">
          {{ $errors->first('description') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="subdescription" class="form-label">Horas (en texto)</label>
      <input type="text" class="form-control" id="subdescription" name="subdescription"
        value="{{ isset($event) ? old('subdescription', $event->subdescription) : old('subdescription') }}">
      @error('subdescription')
        <span class="text-danger">
          {{ $errors->first('subdescription') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="date" class="form-label">Fecha</label>
      <input type="date" class="form-control" id="date" name="date"
        value="{{ isset($event) ? old('date', $event->only_date) : old('date') }}">
      @error('date')
        <span class="text-danger">
          {{ $errors->first('date') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="time" class="form-label m-0">Hora</label>
      <p class="mb-2 fs-6">La hora solo se muestra en hora estándar central (CST-6)</p>
      <input type="time" class="form-control" id="time" name="time"
        value="{{ isset($event) ? old('time', $event->only_time) : old('time') }}">
      @error('time')
        <span class="text-danger">
          {{ $errors->first('time') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="cap" class="form-label">Capacidad</label>
      <input type="number" class="form-control text-right" id="cap" name="cap"
        value="{{ isset($event) ? old('cap', $event->cap) : old('cap', 15) }}">
      @error('cap')
        <span class="text-danger">
          {{ $errors->first('cap') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="price" class="form-label">Precio</label>
      <input type="number" class="form-control text-right" id="price" name="price"
        value="{{ isset($event) ? old('price', $event->price) : old('price', 100) }}">
      @error('price')
        <span class="text-danger">
          {{ $errors->first('price') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="mailContent" class="form-label">Respuesta de correo</label>
      <textarea class="form-control" id="mailContent" name="mailContent">{{ isset($event) ? old('mailContent', $event->mailContent) : old('mailContent') }}</textarea>
      @error('mailContent')
        <span class="text-danger">
          {{ $errors->first('mailContent') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    @isset($event)
      <div class="col-sm-12 col-md-6 col-lg-4 my-3">
        <label for="hide" class="form-label">Ocultar</label>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="hide" name="hide"
            @checked(old('hide', $event->hide))>
        </div>
        @error('hide')
          <span class="text-danger">
            {{ $errors->first('hide') }}
          </span>
        @enderror
      </div>
      <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>
    @endisset

    <div class="col-12 mt-5 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary py-2 px-4">
        {{ isset($event) ? 'Actualizar' : 'Guardar' }}
      </button>
    </div>
  </form>

  @isset($event)
    <div class="col-12 my-3">
      <h1 class="h4">Inscritos</h1>
      <hr class="my-4">
      <ul class="list-group">
        @foreach ($event->orders as $order)
          <li class="list-group-item">
            <div class="row">
              <div class="col-8 d-flex align-items-center">
                {{ $order->name }} / {{ $order->email->email }} <br />
                {{ $order->status }}
              </div>
              <div class="col-4 d-flex align-items-center justify-content-end">
                <a class="btn btn-link" href="{{ route('ordenes.edit', ['ordene' => $order->id]) }}">Ver orden</a>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  @endisset

</x-admin-layout>
