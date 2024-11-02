<x-public-page-layout>
  <x-slot:header>
    <div class="my-5"></div>
  </x-slot>
  <x-slot:top>
  </x-slot>

  <section class="row">
    <h2 class="display-6 fw-bold lh-1 mb-4 mb-lg-5 text-primary">Información</h2>
    <div class="col-sm-12 col-lg-10 m-auto">
      <div class="mb-3 mb-lg-5 bg-light shadow-sm rounded">
        <div class="row m-auto p-0">
          <div class="col-12 col-lg-6 p-0">
            <img class="image-section" src="{{ asset('images/tyler-nix-q-motCAvPBM-unsplash.jpg') }}">
          </div>
          <div class="col-12 col-lg-6 p-3 p-lg-5 d-flex flex-column justify-content-center">
            <h3 class="fw-semibold mb-4">Escribo para Sanar: Taller de Escritura Terapéutica</h4>
              <p>
                ¿Alguna vez has experimentado el poder curativo de la escritura? ¿Has sentido cómo las palabras pueden
                ser una
                herramienta poderosa para explorar tus emociones, procesar experiencias difíciles y encontrar paz
                interior?
                Bienvenido a nuestro Taller de Escritura Terapéutica, donde la escritura se convierte en un viaje de
                autodescubrimiento y sanación.
              </p>
              <p>Este taller de Escritura Terapéutica es un espacio seguro y de apoyo donde aprenderás a utilizar la
                escritura
                como una herramienta para el crecimiento personal y la sanación emocional. A través de ejercicios
                cuidadosamente diseñados y actividades reflexivas, te guiaremos en un viaje hacia la autenticidad, la
                autoexpresión y la transformación personal.
              </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-10 m-auto">
      <div class="py-4 px-3 mb-3 mb-lg-5 bg-light shadow-sm rounded">
        <h3 class="fw-semibold mb-4">Beneficios</h4>
          <ol class="entry-content">
            <li class="d-flex align-items-center">
              <p class="m-0">Aprenderás técnicas de escritura terapéutica que te ayudarán a explorar y procesar tus
                emociones de manera
                saludable y constructiva.
              </p>
            </li>
            <hr>
            <li class="d-flex align-items-center">
              <p class="m-0">Descubrirás cómo la escritura puede ser una forma de liberar el estrés, la ansiedad y el
                dolor emocional,
                permitiéndote encontrar una mayor paz interior.

              </p>
            </li>
            <hr>
            <li class="d-flex align-items-center">
              <p class="m-0">Obtendrás herramientas prácticas que podrás aplicar en tu vida diaria para cultivar la
                autoconciencia, la
                resiliencia emocional y el bienestar general.
              <p>
            </li>
          </ol>
      </div>
    </div>
    <div class="col-sm-12 col-lg-10 m-auto">
      <div class="mb-3 mb-lg-5 bg-light shadow-sm rounded">
        <div class="row m-auto p-0">
          <div class="col-12 col-lg-6 p-3 p-lg-5 d-flex flex-column justify-content-center">
            <h3 class="fw-semibold mb-4">¿Por qué este taller es diferente?</h4>
              <p>
                Nuestro enfoque combina la escritura creativa con principios terapéuticos probados para proporcionar una
                experiencia transformadora y profundamente sanadora. Nos centramos en el proceso de escritura en lugar
                del
                producto final, fomentando la autoexploración y el autocuidado.
              </p>
          </div>
          <div class="col-12 col-lg-6 p-0">
            <img class="image-section" src="{{ asset('images/toa-heftiba-QnUywvDdI1o-unsplash.jpg') }}">
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-10 m-auto">
      <div class="py-4 px-3 mb-3 mb-lg-5 bg-light shadow-sm rounded">
        <h3 class="fw-semibold mb-4">¿Qué incluye el taller?</h4>

          <ol class="entry-content">
            <li class="d-flex align-items-center">
              <p class="m-0">
                Dos sesiones grupales de 2 horas y media cada una
              </p>
            </li>
            <hr>
            <li class="d-flex align-items-center">
              <p class="m-0">
                Ejercicios prácticos diseñados para ayudarte a conectar con tus emociones, desbloquear tu creatividad y
                encontrar tu voz auténtica como escritor y como ser humano.

              </p>
            </li>
            <hr>
            <li class="d-flex align-items-center">
              <p class="m-0">
                Retroalimentación y apoyo individualizado para ayudarte a superar bloqueos creativos, explorar temas
                difíciles y avanzar en tu viaje de sanación personal.
              <p>
            </li>
            <hr>
            <li class="d-flex align-items-center">
              <p class="m-0">
                Acceso a una comunidad de personas que comparten tu interés en la escritura como
                herramienta de sanación, donde podrás encontrar inspiración, apoyo y conexión.
              </p>
            </li>
          </ol>
      </div>
    </div>
    <div class="col-sm-12 col-lg-10 m-auto">
      <div class="py-4 px-3 mb-3 mb-lg-5 bg-light shadow-sm rounded">
        <p class="text-center">Si estás listo para embarcarte en un viaje de autodescubrimiento y sanación a través de
          la escritura, ¡este
          taller es para ti! Únete a nosotros y descubre el poder transformador de escribir para sanar.
        </p>
        <div class="text-center">
          <a class="btn btn-secondary" href="{{ route('register') }}">Inscribir</a>
        </div>
      </div>
    </div>
  </section>

  @push('scripts')
    <script src="{{ asset('js/information.js') }}"></script>
  @endpush
</x-public-page-layout>
