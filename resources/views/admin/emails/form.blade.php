<x-admin-layout>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
      @if (isset($email))
        Modificar correo
      @else
        Añadir correo
      @endif
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
        href="{{ session('email:index', route('correos.index')) }}" role="button">
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
    action="{{ isset($email) ? route('correos.update', ['correo' => $email->id]) : route('correos.store') }}">
    @csrf
    @isset($email)
      @method('PUT')
    @endisset
    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="name" class="form-label">Nombre</label>
      <input type="text" class="form-control" id="name" name="name"
        value="{{ isset($email) ? old('name', $email->name) : old('name') }}">
      @error('name')
        <span class="text-danger">
          {{ $errors->first('name') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="email" class="form-label">Correo</label>
      <input type="text" class="form-control" id="email" name="email"
        value="{{ isset($email) ? old('email', $email->email) : old('email') }}">
      @error('email')
        <span class="text-danger">
          {{ $errors->first('email') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    @isset($email)
      <div class="col-sm-12 col-md-6 col-lg-4 my-3">
        <label for="newsletter" class="form-label">Suscripcion</label>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="newsletter" name="newsletter"
            @checked(old('newsletter', $email->newsletter))>
        </div>
        @error('newsletter')
          <span class="text-danger">
            {{ $errors->first('newsletter') }}
          </span>
        @enderror
      </div>
      <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>
    @endisset

    <div class="col-sm-12 col-md-6 col-lg-4 my-3">
      <label for="phone" class="form-label">Teléfono</label>
      <input type="text" class="form-control" id="phone" name="phone"
        value="{{ isset($email) ? old('phone', $email->phone) : old('phone') }}">
      @error('phone')
        <span class="text-danger">
          {{ $errors->first('phone') }}
        </span>
      @enderror
    </div>
    <div class="offset-sm-0 offset-md-6 offset-lg-8"></div>

    <div class="col-12 mt-5 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary py-2 px-4">
        {{ isset($email) ? 'Actualizar' : 'Guardar' }}
      </button>
    </div>
  </form>

  @isset($email)
    <div class="col-12 my-3">
      <h1 class="h4">Talleres</h1>
      <hr class="my-4">
      <ul class="list-group">
        @foreach ($email->orders as $order)
          <li class="list-group-item">
            <div class="row">
              <div class="col-8 d-flex align-items-center">
                Alias: {{ $order->name }} <br />
                Taller: {{ $order->event->name }} / {{ $order->event->formattedDate }}
                {{ $order->event->formattedTime }}
              </div>
              <div class="col-4 d-flex align-items-center justify-content-end">
                <a class="btn btn-link" href="{{ route('eventos.edit', ['evento' => $order->event->id]) }}">Ver
                  taller</a>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  @endisset
</x-admin-layout>
