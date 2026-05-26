<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">

    <div class="container-fluid">

        <div class="navbar-wrapper">

            {{-- BOTON SIDEBAR RESPONSIVE --}}
            <div class="navbar-toggle">

                <button type="button" class="navbar-toggler">

                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>

                </button>

            </div>

            {{-- TITULO --}}
            <a class="navbar-brand" href="#">
                Sistema de Gestión
            </a>

        </div>

        {{-- BOTON MOBILE --}}
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navigation"
            aria-controls="navigation-index"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>

        </button>

        {{-- MENU DERECHO --}}
        <div class="collapse navbar-collapse justify-content-end"
            id="navigation">

            {{-- BUSCADOR --}}
            <form>

                <div class="input-group no-border">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Buscar..."
                    >

                    <div class="input-group-append">

                        <div class="input-group-text">

                            <i class="nc-icon nc-zoom-split"></i>

                        </div>

                    </div>

                </div>

            </form>

            {{-- ICONOS DERECHA --}}
            <ul class="navbar-nav">

                {{-- DASHBOARD --}}
                <li class="nav-item">

                    <a class="nav-link btn-magnify" href="#">

                        <i class="nc-icon nc-layout-11"></i>

                    </a>

                </li>

                {{-- NOTIFICACIONES --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdownMenuLink"
                        data-toggle="dropdown">
                        <i class="nc-icon nc-bell-55"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">
                            Sin notificaciones
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>