<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Controle de Registros</title>

         <!-- Adicione os estilos do WebcamJS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.css" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

         <!-- Local style -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/camera.css')}}">

         <!-- Datatables buttons -->
         <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
         <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">

        {{-- selectize --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

        {{-- moment --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        {{-- IMask --}}
        <script src="https://unpkg.com/imask"></script>

        {{-- Livewire --}}
        @livewireStyles

        {{-- ícone dropdown do selectize --}}
        <style>
            .selectize-input::after {
                position: absolute !important;
                top: 3px !important;
                right: 0px !important;
                content: ' '!important;
                width: 36px !important;
                height: 36px !important;
                border: none !important;
                background-color: white;
                background-image: url('../images/dropdown.svg') !important;
                background-size: 12px;
                background-position: center;
                background-repeat: no-repeat
            }
        </style>
    </head>
    <body>

        @include('layouts.header')

        <main class="d-flex flex-nowrap">

            @include('layouts.sidebar')

            <div id="content" class="border">
                @yield('content')
            </div>
        </main>

        @include('layouts.footer')
    </body>
    @include('components.loading')

    {{-- Livewire --}}
    @livewireScripts

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

</html>
