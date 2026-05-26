<div class="wrapper">

    {{-- SIDEBAR --}}
    @include('layouts.navbars.auth')

    <div class="main-panel">

        {{-- NAVBAR SUPERIOR --}}
        @include('layouts.navbars.navs.auth')

        {{-- CONTENIDO --}}
        <div class="content">

            <div class="container-fluid">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- BREADCRUMB --}}
                @isset($breadcrumb)
                    <div class="content-header mb-3">
                        {!! $breadcrumb !!}
                    </div>
                @endisset

                {{-- CONTENIDO DE LAS VISTAS --}}
                @yield('content')

            </div>

        </div>

        {{-- FOOTER --}}
        @include('layouts.footer')

    </div>

</div>