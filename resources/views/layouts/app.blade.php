<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Mi Tienda')</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @vite('resources/css/app.css')
  @vite('resources/css/estilosprincipal.css')
  <script src="https://kit.fontawesome.com/tu-kit-id.js" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .popup {
      background: #fff;
      border-radius: 12px;
      width: 600px;
      display: flex;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      animation: fadeInTopLeft 0.8s ease-out;
      position: relative;
    }

    .popup.fadeOut {
      animation: fadeOutBottomRight 0.5s ease-out forwards;
    }

    .popup .left {
      flex: 1;
      background: url('https://previews.123rf.com/images/seventyfour74/seventyfour742307/seventyfour74230700787/209288709-vertical-background-image-of-empty-clothing-boutique-interior-in-elegant-pink-colors-copy-space.jpg') center/cover no-repeat;
    }

    @keyframes fadeInTopLeft {
      0% {
        transform: translate(-100%, -100%);
        opacity: 0;
      }

      100% {
        transform: translate(0, 0);
        opacity: 1;
      }
    }

    @keyframes fadeOutBottomRight {
      0% {
        transform: translate(0, 0);
        opacity: 1;
      }

      100% {
        transform: translate(100%, 100%);
        opacity: 0;
      }
    }
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

  @include('partials.navbar')

  <main class="pt-46">
    @yield('content')
  </main>

  @include('partials.footer')
  @stack('scripts')

</body>




</html>