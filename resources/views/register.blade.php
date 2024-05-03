<x-public-page-layout>
  <x-slot:header>
    <div class="my-5"></div>
  </x-slot>
  <x-slot:top>
  </x-slot>

  <section class="row">
    <form class="row g-0" method="POST" action="{{ route('register') }}" name="registration">
      @csrf
      <div class="col-sm-12 col-md-7 col-lg-7 pe-0 pe-md-2">
        <div class="py-4 px-3 mb-3 mb-lg-5 bg-light shadow-sm rounded">
          <h4 class="fw-semibold mb-4">Taller</h4>
          <div class="list-group list-group-radio d-grid gap-2 border-0">

            @foreach ($events as $event)
              <div class="position-relative">
                <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio" name="eventId"
                  id="{{ 'eventId-' . $event->id }}" value="{{ $event->id }}" data-price="{{ $event->price }}"
                  @checked(old('eventId', 0) == $event->id)>
                <label class="list-group-item py-3 pe-5" for="{{ 'eventId-' . $event->id }}">
                  <div class="row">
                    <div class="col">
                      <p class="h4 text-capitalize text-primary"><strong>{{ $event->name }}</strong></p>
                      <p class="h4 text-capitalize text-primary">{{ $event->description }}</p>
                      <p class="m-0 text-primary"><small>{{ $event->subdescription }}</small></p>
                    </div>
                    <div class="col-5 d-flex justify-content-end align-items-center">
                      <p class="m-0 fs-3 lh-1 text-primary">$
                        {{ (int) $event->price }}<sup
                          class="fs-6 text-primary">{{ substr($event->price, -2) }}</sup><small class="fs-6">
                          MXN</small></p>
                    </div>
                  </div>
                </label>
              </div>
            @endforeach

            @error('eventId')
              <span class="text-danger">
                {{ $errors->first('eventId') }}
              </span>
            @enderror
          </div>
          <hr class="my-5">
          <h4 class="fw-semibold mb-4">Información</h4>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name"
              placeholder="Algún nombre para identificarte" value="{{ old('name', '') }}">
            <label for="name">Nombre</label>
            @error('name')
              <span class="text-danger">
                {{ $errors->first('name') }}
              </span>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com"
              value="{{ old('email', '') }}">
            <label for="email">Correo</label>
            @error('email')
              <span class="text-danger">
                {{ $errors->first('email') }}
              </span>
            @enderror
          </div>
          <p><small>Por favor proporcionanos un nombre para identificarte en el taller y un correo para envíarte el
              recibo
              y las instrucciones de como acceder al taller.</small></p>
        </div>
      </div>
      <div class="col-sm-12 col-md-5 col-lg-5 ps-0 ps-md-2">
        <div class="py-4 px-3 mb-3 mb-lg-5 bg-light shadow-sm rounded">
          <div id="register-message" class="text-center fs-6">
            Por favor selecciona un taller
          </div>
          <div id="register-button" hidden="">
            <button class="w-100 mb-3 btn btn-lg btn-primary d-inline-flex justify-content-center align-items-center"
              type="submit">
              Inscribirse
            </button>
          </diV>
          <div id="paypal-button-container" hidden=""></div>
        </div>
      </div>
    </form>
  </section>
  @push('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_ID') }}&currency=MXN"></script>
    <script src="{{ asset('js/register.js') }}"></script>
  @endpush
</x-public-page-layout>
