let departamentoDetectado = null;

function cotizacionForm() {

    return {

        tipo: window.cotizacionData.old.tipo ?? '',

        estado: window.cotizacionData.old.estado ?? 'enviado',

        fechaEnvio: window.cotizacionData.old.fechaEnvio ?? '',

        dependenciaId: window.cotizacionData.old.dependenciaId ?? '',

        analistaId: window.cotizacionData.old.analistaId ?? '',

        departamentoId: window.cotizacionData.old.departamentoId ?? '',

        dependencias: window.cotizacionData.dependencias ?? [],

        analistas: window.cotizacionData.analistas ?? [],

        departamentos: window.cotizacionData.departamentos ?? [],

    };
}

/* =======================================================
   MODALES
======================================================= */

function cerrarModalDepartamento()
{
    const modalEl = document.getElementById('modalDepartamento');

    const modal = bootstrap.Modal.getInstance(modalEl);

    if (modal) {
        modal.hide();
    }
}

function cerrarModalAnalista()
{
    const modalEl = document.getElementById('modalAnalista');

    const modal = bootstrap.Modal.getInstance(modalEl);

    if (modal) {
        modal.hide();
    }
}

/* =======================================================
   ANALISTA
======================================================= */

async function guardarAnalista()
{
    const payload = {

        nombre:
            (document.getElementById('nuevo_nombre').value || '').trim(),

        apellido_paterno:
            (document.getElementById('nuevo_apellido_paterno').value || '').trim(),

        apellido_materno:
            (document.getElementById('nuevo_apellido_materno').value || '').trim(),

        telefono:
            (document.getElementById('nuevo_telefono').value || '').trim(),

        email:
            (document.getElementById('nuevo_email').value || '')
                .trim()
                .toLowerCase(),
    };

    if (!payload.nombre || !payload.apellido_paterno) {

        alert('Nombre y apellido paterno son obligatorios');

        return;
    }

    try {

        const response = await fetch(
            window.cotizacionData.routes.analistasStore,
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN':
                        window.cotizacionData.csrfToken,
                },

                body: JSON.stringify(payload),
            }
        );

        const data = await response.json();

        if (!response.ok) {

            console.error(data);

            alert(data.message || 'Error al guardar analista');

            return;
        }

        const select =
            document.querySelector('select[name="analista_id"]');

        const option = document.createElement('option');

        option.value = data.id;

        option.text = data.nombre;

        option.selected = true;

        select.appendChild(option);

        select.value = data.id;

        cerrarModalAnalista();

    } catch (error) {

        console.error(error);

        alert('Error de red');
    }
}

/* =======================================================
   DEPARTAMENTO
======================================================= */

async function guardarDepartamento()
{
    if (departamentoDetectado) {

        alert(
            'Este departamento ya existe, usa "Usar este departamento"'
        );

        return;
    }

    const payload = {

        dependencia_id:
            document.getElementById('nuevo_dependencia_id')?.value || null,

        nombre_departamento:
            (document.getElementById('nuevo_departamento').value || '').trim(),

        responsable:
            (document.getElementById('nuevo_responsable').value || '').trim(),

        telefono:
            (document.getElementById('nuevo_departamento_telefono').value || '')
                .replace(/\D/g, ''),

        email:
            (document.getElementById('nuevo_departamento_email').value || '')
                .trim()
                .toLowerCase(),

        direccion:
            (document.getElementById('nuevo_departamento_direccion').value || '')
                .trim(),
    };

    if (!payload.nombre_departamento) {

        alert('El nombre del departamento es obligatorio');

        return;
    }

    try {

        const response = await fetch(
            window.cotizacionData.routes.departamentosStore,
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN':
                        window.cotizacionData.csrfToken,
                },

                body: JSON.stringify(payload),
            }
        );

        const data = await response.json();

        if (!response.ok) {

            console.error(data);

            alert(data.message || 'Error al guardar departamento');

            return;
        }

        const select =
            document.querySelector('select[name="departamento_id"]');

        const option = document.createElement('option');

        option.value = data.id;

        option.text =
            data.responsable ?? data.nombre_departamento;

        option.selected = true;

        select.appendChild(option);

        select.value = data.id;

        departamentoDetectado = null;

        const alerta =
            document.getElementById('departamento-existente');

        if (alerta) {
            alerta.classList.add('d-none');
        }

        cerrarModalDepartamento();

    } catch (error) {

        console.error(error);

        alert('Error de red');
    }
}

/* =======================================================
   BUSCAR DEPARTAMENTO EXISTENTE
======================================================= */

async function buscarDepartamentoExistente()
{
    const email =
        (document.getElementById('nuevo_departamento_email').value || '')
            .trim()
            .toLowerCase();

    const telefono =
        (document.getElementById('nuevo_departamento_telefono').value || '')
            .replace(/\D/g, '');

    if (!email && !telefono) {
        return;
    }

    try {

        const response = await fetch(
            `${window.cotizacionData.routes.departamentosBuscar}?email=${encodeURIComponent(email)}&telefono=${encodeURIComponent(telefono)}`
        );

        const departamento = await response.json();

        if (departamento && departamento.id) {

            departamentoDetectado = departamento;

            document.getElementById('departamento-existente')
                .classList.remove('d-none');

            document.getElementById('departamento-info').innerText =
                `${departamento.nombre_departamento ?? 'Sin departamento'} - ${departamento.responsable ?? 'Sin responsable'}`;

        } else {

            departamentoDetectado = null;

            document.getElementById('departamento-existente')
                .classList.add('d-none');
        }

    } catch (error) {

        console.error(error);
    }
}

/* =======================================================
   USAR DEPARTAMENTO EXISTENTE
======================================================= */

function usarDepartamentoExistente()
{
    if (!departamentoDetectado) {
        return;
    }

    const select =
        document.querySelector('select[name="departamento_id"]');

    select.value = departamentoDetectado.id;

    cerrarModalDepartamento();
}

/* =======================================================
   EVENTOS
======================================================= */

document.addEventListener('DOMContentLoaded', () => {

    const email =
        document.getElementById('nuevo_departamento_email');

    const telefono =
        document.getElementById('nuevo_departamento_telefono');

    if (email) {
        email.addEventListener(
            'blur',
            buscarDepartamentoExistente
        );
    }

    if (telefono) {
        telefono.addEventListener(
            'blur',
            buscarDepartamentoExistente
        );
    }
});