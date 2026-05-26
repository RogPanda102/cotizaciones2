<div class="sidebar" data-color="white" data-active-color="danger">

    <div class="logo">

        <a href="{{ route('cotizaciones.index') }}"
            class="simple-text logo-mini">

            <div class="logo-image-small">

                <img src="{{ asset('images/logo-header-2.png') }}">

            </div>

        </a>

        <a href="{{ route('cotizaciones.index') }}"
            class="simple-text logo-normal">

            Sistema Gestión

        </a>

    </div>

    <div class="sidebar-wrapper">

        <ul class="nav">

            {{-- DASHBOARD --}}
            <li>

                <a href="{{ route('cotizaciones.index') }}">

                    <i class="nc-icon nc-paper"></i>

                    <p>Cotizaciones</p>

                </a>

            </li>

            {{-- DEPENDENCIAS --}}
            <li>

                <a href="{{ route('dependencias.index') }}">

                    <i class="nc-icon nc-bank"></i>

                    <p>Dependencias</p>

                </a>

            </li>

            {{-- PROVEEDORES --}}
            <li>

                <a href="{{ route('proveedores.index') }}">

                    <i class="nc-icon nc-delivery-fast"></i>

                    <p>Proveedores</p>

                </a>

            </li>

            {{-- PEDIDOS --}}
            <li>

                <a href="{{ route('pedidos.index') }}">

                    <i class="nc-icon nc-cart-simple"></i>

                    <p>Pedidos</p>

                </a>

            </li>

        </ul>

    </div>

</div>