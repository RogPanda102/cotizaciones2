<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Gestión</title>

    {{-- PAPER DASHBOARD --}}
    <link href="{{ asset(config('rutas.dashboard_css') . 'bootstrap.min.css') }}"
        rel="stylesheet" />

    <link href="{{ asset(config('rutas.dashboard_css') . 'paper-dashboard.css?v=2.0.0') }}"
        rel="stylesheet" />

    {{-- ICONOS --}}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"
        rel="stylesheet">

    {{-- TOASTR --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- CSS ESPECIFICOS --}}
    @stack('styles')

</head>

<body>

    {{-- TEMPLATE PRINCIPAL --}}
    @include('layouts.page_templates.auth')

    {{-- NOTIFICACIONES --}}
    <script src="{{ asset(config('rutas.js_especificos') . 'notificaciones_alertas.js') }}"></script>

    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- PAPER DASHBOARD --}}
    <script src="{{ asset(config('rutas.dashboard_js') . 'paper-dashboard.min.js?v=2.0.0') }}"></script>

    {{-- VALIDACIONES --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    {{-- TOASTR --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- ALPINE --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SCRIPTS ESPECIFICOS --}}
    @stack('scripts')

    {!! mostrar_mensaje() !!}

</body>

</html>