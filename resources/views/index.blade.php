@php
    $isPanel = request()->is(['panel/*', 'login', 'forgot-password', 'register']); // Verifica si la URL empieza con "panel/" o el login
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>

    @if ($isPanel)
        <!--Estilos del panel admin -->
        @vite(['resources/styles/main.scss', 'resources/app/main.js'])
    @else
        <!--Estilos del frontend website -->
        @vite(['resources/styles/scss/style.scss',
         'resources/styles/plugins.css',
         'resources/styles/colors/colors.css',
         'resources/app/main.js'//no quitar
         ])
    @endif

    <script>
        window.AppConfig = {
            name: '{{ env('APP_NAME') }}',
            logo: '{{ url('/assets/panel/images/logo.png') }}',
            url: '{{ env('APP_URL') }}',
            csrf: '{{ csrf_token() }}',
            defaultLocale: '{{ App\Models\Setting::where('id', 1)->first()['locale'], env('APP_LOCALE') }}',
            defaultTimezone: '{{ App\Models\Setting::where('id', 1)->first()['timezone'], env('APP_TIMEZONE') }}',
            locales: {
                en: {!! json_encode(\Illuminate\Support\Facades\Lang::get('frontend', [], 'en')) !!},
                mk: {!! json_encode(\Illuminate\Support\Facades\Lang::get('frontend', [], 'mk')) !!},
                es: {!! json_encode(\Illuminate\Support\Facades\Lang::get('frontend', [], 'es')) !!},
            }
        }
    </script>
</head>

<body>
    <noscript>
        <strong>We're sorry but this application doesn't work properly without JavaScript enabled. Please enable it to
            continue.</strong>
    </noscript>

    <div id="app"></div>

</body>

</html>
