@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
    // 'csrfToken' => csrf_token(),
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ mix('dist/css/all.css')}}">
  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
  <script src="{{ asset('asset/js/jquery-3.5.1.min.js') }}"></script>
  <script>
    (function(){
      window.Laravel = {
        csrfToken:'{{ csrf_token() }}',
        base_url:"{{URL::to('/')}}"
      }
    })();
  </script>
</head>
<body>
  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>
    window.config = @json($config);
  </script>
  {{-- <script cript type="text/javascript">
   
  </script> --}}
  {{-- Load the application scripts --}}
  <script src="{{ mix('dist/js/app.js') }}"></script>
  
</body>
</html>
