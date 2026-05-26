<?php
    use App\Enums\TipoAlerta;
    // =======================  
    // B R E A D   C R U M B
    // =======================
    function breadcrumb($tarea = '', $breadcrumb = array())
{
    $html = '';
    if (sizeof($breadcrumb) > 0) {
        $html .= '
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h3 class="mb-0 fw-bold text-dark">
                    '.$tarea.'
                </h3>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    Panel de administración
                </p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a href="'.route(('empresas.index')).'"
                            class="text-decoration-none">
                            Inicio
                        </a>
                    </li>
        ';

        foreach ($breadcrumb as $nav) {
            if (isset($nav['href'])) {
                if ($nav["href"] != '#') {
                    $html .= '
                        <li class="breadcrumb-item">
                            <a href="'.$nav["href"].'"
                                class="text-decoration-none">
                                '.$nav["tarea"].'
                            </a>
                        </li>
                    ';
                } else {
                    $html .= '
                        <li class="breadcrumb-item active text-dark"
                            aria-current="page">
                            '.$nav["tarea"].'
                        </li>
                    ';
                }
            }
        }
        $html .= '
                </ol>
            </nav>
        </div>
        ';
    }
    return $html;
}

    function mensaje($texto = "",TipoAlerta $tipo = TipoAlerta::INFO,$tiempo = 1000)
    {
        $mensaje = array();
        $mensaje['texto'] = $texto;
        $mensaje['tipo'] = $tipo->value;
        $mensaje['tiempo'] = $tiempo;
        session_put('mensaje', $mensaje);

    }//end function

    function mostrar_mensaje()
    {
        $html = '';

        $mensaje = session('mensaje');

        // 🔥 Si no existe mensaje
        if (!$mensaje) {
            return "";
        }

        switch($mensaje['tipo']) {

            case TipoAlerta::SUCCESS->value:

                $tipoMensaje = "success";
                $titulo = "¡Correcto!";

            break;

            case TipoAlerta::DANGER->value:

                $tipoMensaje = "error";
                $titulo = "¡Error!";

            break;

            case TipoAlerta::WARNING->value:

                $tipoMensaje = "warning";
                $titulo = "¡Atención!";

            break;

            default:

                $tipoMensaje = "info";
                $titulo = "¡Bienvenido!";

            break;
        }
        session_forget('mensaje');

        $html = '
            <script>

                toastr["'.$tipoMensaje.'"](
                    "'.$mensaje["texto"].'",
                    "'.$titulo.'",
                    {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "showDuration": "'.$mensaje["tiempo"].'",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                );

            </script>
        ';
        return $html;
    }