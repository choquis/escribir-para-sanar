<x-public-page-layout>
  <x-slot:header>
    <header>
      <img class="header-image header-image-responsivnes"
        src="{{ asset('images/engin-akyurt-fEG6djtQffM-unsplash-wide.jpg') }}">
      <div class="mask header-block"></div>
      <div class="container header-block d-flex flex-column justify-content-center align-items-start">
        <div class="position-relative overflow-hidden flex-fill align-content-center">
          <div class="col-10 col-lg-6 my-5 text-left text-shadow">
            <p class="h3 fw-bold text-light">
              Permíteme acompañarte en esta aventura de expresión emocional.
            </p>
            <p class="h5 text-light">
              Taller en línea. Se abrirán dos grupos con cupo limitado.
            </p>
          </div>
        </div>
        <div id="scroll-message" class="position-relative overflow-hidden align-self-center">
          <div class="col-sm-12 my-5 text-shadow">
            <p class="h6 text-light text-center">
              Desliza para ver talleres <br />
              <i class="bi bi-chevron-compact-down"></i>
            </p>
          </div>
        </div>
      </div>
    </header>
  </x-slot>

  <x-slot:top>
    <section class="mt-5">
      <div class="container">
        <div class="card">
          <div class="row m-auto p-0">
            <div class="col-12 col-lg-6 p-0">
              <img class="image-section" src="{{ asset('images/john-jennings-Aet6IBKXJSg-unsplash.jpg') }}">
            </div>
            <div class="col-12 col-lg-6 p-3 p-lg-5">
              <h3 class="display-6 fw-bold lh-1 mb-4 mb-lg-5 text-primary text-center">¿Qué puedes esperar de este taller?</h3>
              <ol class="entry-content">
                <li class="d-flex align-items-center">
                  <p class="m-0">
                    Aprenderás a identificar, sentir y desahogar las emociones que has tenido reprimidas en tu interior.
                  </p>
                </li>
                <hr>
                <li class="d-flex align-items-center">
                  <p class="m-0">
                    Reconocerás el poder sanador de tus palabras.
                  </p>
                </li>
                <hr>
                <li class="d-flex align-items-center">
                  <p class="m-0">
                    Al escribir, aprenderás a desconectarte del ruido del exterior y del ruido de tus propios
                    pensamientos.
                  <p>
                </li>
                <hr>
                <li class="d-flex align-items-center">
                  <p class="m-0">
                    Al escribir comenzarás a ordenar, lo que en tu mente parecía imposible de ordenar.
                  </p>
                </li>
                <ol>
            </div>
          </div>
        </div>
      </div>
    </section>
  </x-slot>

  @if (isset($events) && count($events) > 0)
    <section class="row py-4 px-lg-4 p-lg-5 mb-lg-5">
      <h3 class="display-6 fw-bold lh-1 mb-4 mb-lg-5 text-center">Grupos y fechas:</h3>
      <div class="card col-11 col-lg-8 m-auto p-0 d-flex justify-content-center">
        <ul class="list-group list-group-flush">
          @foreach ($events as $event)
            <li class="list-group-item list-group-item-action py-3">
              <div class="row">
                <div class="col-2 d-flex justify-content-end align-items-center">
                  <i class="bi bi-calendar2-week fs-1 text-primary"></i>
                </div>
                <div class="col">
                  <p class="h4 text-capitalize text-primary"><strong>{{ $event->name }}</strong></p>
                  <p class="h4 text-capitalize text-primary">{{ $event->description }}</p>
                  <p class="m-0"><small>{{ $event->subdescription }}</small></p>
                </div>
                <div class="col-3 d-flex justify-content-center align-items-center">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('register') }}">
                    Inscribir
                  </a>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </section>
  @else
    <section class="row py-4 px-lg-4 p-lg-5 mb-lg-5 d-flex justify-content-center">
      <div class="col-12 col-md-7">
        <p class="h3 lh-1 mb-4 fw-bold text-center">
          Lo sentimos pero ahora no hay talleres disponibles
        </p>
        <p class="fs-5 lh-1 text-center">
          Te invitamos a suscribirte para avisarte lo mas pronto posible
          cuando abramos otro
        </p>
      </div>
    </section>
  @endif

  <section class="row py-4 px-lg-4 p-lg-5">
    <div class="col-lg-7 py-4">
      <h3 class="fw-bold lh-1 mb-3">Puedes pasarme tu correo</h3>
      <p class="col-lg-10 fs-4">
        Para mantenernos en contacto
      </p>
    </div>
    <div class="col-lg-5 py-4 d-flex justify-content-center align-items-center">
      <form class="w-100" method="POST" action="{{ route('subscribe') }}" name="subscription">
        @csrf
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com">
          <label for="email">Correo</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Suscribir</button>
      </form>
    </div>
  </section>
  @push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
  @endpush
</x-public-page-layout>
