<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Nosotros somos un grupo de escritores y escritoras, nos juntamos para crecer mental y emocionalmente junto con la actividad de la escritura terapéutica. Con este sitio puedes inscribirte a nuestros talleres semanales de escritura terapéutica."/>
  <title>Escribo para sanar</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=alexandria:200,300,600" rel="stylesheet" />

  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- custom boostrap css -->
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  @stack('styles')

</head>

<body class="font-sans d-flex flex-column h-100 bg-color text-primary">

  <!-- Navbar -->
  <nav id="navbar" class="navbar navbar-expand-lg fixed-top container transparent-navbar">
    <div class="container-fluid">
      <!-- boton hamburgesa mobil
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
          aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        -->
      <a id="logo" class="navbar-brand col-lg-3 me-0 d-flex align-items-center font-cursive simple-logo"
        href="{{ route('home') }}">
        Escribo para sanar
      </a>
      <!-- Menu central
        <div class="collapse navbar-collapse justify-content-md-center" id="navbar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Acerca de nosotros</a>
            </li>
          </ul>
        </div>
        -->
      <div id="navbar-inscription" class="d-flex col-lg-3 justify-content-lg-end d-none">
        <a class="btn btn-outline-secondary" href="{{ route('register') }}">Inscribir</a>
      </div>
    </div>
  </nav>

  {{ $header }}

  <div class="w-100 color-bg">
    <main class="container py-5">
      {{ $slot }}
    </main>
  </div>

  <!-- footer-->
  <footer class="mt-auto bg-primary text-secondary">
    <div class="container d-flex flex-wrap justify-content-between align-items-center p-3">
      <div class="col-md-4 d-flex align-items-center">
        <i class="bi bi-whatsapp me-2"></i>
        <span class="mb-0 text-white">+52 1 81 2203 7426</span>
      </div>

      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3">
          <a href="#">
            <i class="bi bi-instagram text-secondary"></i>
          </a>
        </li>
        <!--
        <li class="ms-3">
          <a href="#">
            <i class="bi bi-twitter"></i>
          </a>
        </li>
        <li class="ms-3">
          <a href="#">
            <i class="bi bi-youtube"></i>
          </a>
        </li>
        -->
      </ul>
    </div>
  </footer>

  <!-- Mensajes tipo notificacion -->
  <x-simple-notification />

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  @stack('scripts')
</body>

</html>
