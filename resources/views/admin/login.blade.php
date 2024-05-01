<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>M</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=alexandria:200,300,600" rel="stylesheet" />

  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="font-sans bg-body-tertiary">

  <div class="position-relative h-100">
    <div class="container-fluid position-absolute top-50 start-50 translate-middle">
      <div class="row justify-content-md-center">
        <div class="col-md-auto mx-auto py-3">
          @error('invalid')
            <div class="alert alert-warning alert-dismissible" role="alert">
              <div> {{ $message }} </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @enderror
          <form class="row" method="POST" action="{{ route('authenticate') }}">
            @csrf
            <div class="col-sm-12 my-3">
              <label class="form-label" for="name">Usuario</label>
              <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name') }}" />
              @error('name')
                <span class="text-danger">Necesitamos el usuario</span>
              @enderror
            </div>
            <div class="col-sm-12 my-3">
              <label class="form-label" for="password">Contraseña</label>
              <input type="password" class="form-control" id="inputPassword" name="password" />
              @error('password')
                <span class="text-danger">Necesitamos la contraseña</span>
              @enderror
            </div>
            <div class="col-sm-12 my-3">
              <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
