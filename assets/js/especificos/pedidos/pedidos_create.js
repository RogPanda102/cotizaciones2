let departamentoDetectado = null;

function pedidoForm() {

    return {
        dependencias: window.appData?.dependencias ?? [],

        tipo: window.pedidoOld?.tipo ?? '',

        dependenciaId: window.pedidoOld?.dependenciaId ?? '',

        departamentoId: window.pedidoOld?.departamentoId ?? '',

        analistaId: window.pedidoOld?.analistaId ?? '',

        get departamentosFiltrados() {

            const dependencia = this.dependencias.find(
                dep => dep.id == this.dependenciaId
            );

            return dependencia
                ? dependencia.departamentos
                : [];
        },

        limpiarDepartamento() {

            this.departamentoId = '';

        }

    };

}

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
    if (modal)
    {
        modal.hide();
    }
}


function guardarAnalista() {

    const payload = {

        nombre: (document.getElementById('nuevo_analista_nombre').value || '').trim(),

        apellido_paterno: (document.getElementById('nuevo_analista_apellido_paterno').value || '').trim(),

        apellido_materno: (document.getElementById('nuevo_analista_apellido_materno').value || '').trim(),

        telefono: (document.getElementById('nuevo_analista_telefono').value || '').trim(),

        email: (document.getElementById('nuevo_analista_email').value || '').trim().toLowerCase(),

    };

    if (!payload.nombre || !payload.apellido_paterno) {

        alert('Nombre y apellido paterno son obligatorios');

        return;
    }

    fetch(window.appData.routes.analistasStore, {

        method: 'POST',

        headers: {

            'Content-Type': 'application/json',

            'Accept': 'application/json',

            'X-CSRF-TOKEN': window.appData.csrfToken,

        },

        body: JSON.stringify(payload),

    })

    .then(async res => {

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message || 'Error al guardar analista');
        }

        return data;

    })

    .then(analista => {

        const select = document.getElementById('analistaSelect');

        const option = document.createElement('option');

        option.value = analista.id;

        option.text = analista.nombre;

        select.appendChild(option);

        select.value = analista.id;

        cerrarModalAnalista();

    })

    .catch(error => {

        console.error(error);

        alert('Ocurrió un error al guardar el analista');

    });

}

function guardarDepartamento() {

    if (departamentoDetectado) {

        alert('Este departamento ya existe, usa "Usar este departamento"');

        return;
    }

    const payload = {

        nombre_departamento: document.getElementById('nuevo_departamento').value.trim(),

        responsable: document.getElementById('nuevo_contacto').value.trim(),

        telefono: (document.getElementById('nuevo_telefono').value || '').replace(/\D/g, ''),

        email: (document.getElementById('nuevo_email').value || '').trim().toLowerCase(),

        direccion: document.getElementById('nuevo_direccion').value.trim(),

    };

    if (!payload.nombre_departamento) {

        alert('El nombre del departamento es obligatorio');

        return;
    }

    fetch(window.appData.routes.departamentosStore, {

        method: 'POST',

        headers: {

            'Content-Type': 'application/json',

            'Accept': 'application/json',

            'X-CSRF-TOKEN': window.appData.csrfToken,

        },

        body: JSON.stringify(payload),

    })

    .then(res => {

        if (!res.ok) {
            throw new Error('Error al guardar departamento');
        }

        return res.json();

    })

    .then(departamento => {

        const select = document.getElementById('departamentoSelect');

        let option = document.createElement('option');

        option.value = departamento.id;

        option.text = departamento.nombre;

        select.appendChild(option);

        select.value = departamento.id;

        departamentoDetectado = null;

        document.getElementById('departamento-existente').classList.add('d-none');

        cerrarModalDepartamento();

    })

    .catch(error => {

        console.error(error);

        alert('Ocurrió un error al guardar el departamento');

    });

}

// 🔥 BUSCAR DEPARTAMENTO EXISTENTE
function buscarDepartamentoExistente() {

    const email = (document.getElementById('nuevo_email').value || '')
        .trim()
        .toLowerCase();

    const telefono = (document.getElementById('nuevo_telefono').value || '')
        .replace(/\D/g, '');

    if (!email && !telefono) return;

    fetch(
        `${window.appData.routes.departamentosBuscar}?email=${encodeURIComponent(email)}&telefono=${encodeURIComponent(telefono)}`
    )

    .then(res => res.json())

    .then(departamento => {

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

    });

}
// 🔥 USAR DEPARTAMENTO DETECTADO
function usarClienteExistente() {
    if (!departamentoDetectado) return;

    let select = document.getElementById('departamentoSelect');

    select.value = departamentoDetectado.id;

    cerrarModalDepartamento();
}

// 🔥 ACTIVAR DETECCIÓN AUTOMÁTICA
document.addEventListener('DOMContentLoaded', () => {

    const email = document.getElementById('nuevo_email');

    const telefono = document.getElementById('nuevo_telefono');

    if (email) {
        email.addEventListener('blur', buscarDepartamentoExistente);
    }

    if (telefono) {
        telefono.addEventListener('blur', buscarDepartamentoExistente);
    }

});

    $(document).ready(function () {

        $('#formPedido').validate({

            errorClass: 'error',

            highlight: function(element) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },

            rules: {

                dependencia_id: {
                    required: true
                },

                departamento_id: {
                    required: true
                },

                analista_id:{
                    required: true
                },

                proveedor_id:{
                    required: true
                },

                monto_total_aprobado: {
                    required: true
                },

                fecha_adjudicacion: {
                    required: true
                },

                dias_entrega: {
                    required: true
                },

                dias_credito: {
                    required: true
                },

                tipo: {
                    required: true
                },
                lugar_entrega:{
                    required: true
                },
                descripcion_servicio:{
                    required: true
                }

            },

            messages: {

                dependencia_id: {
                    required: 'Selecciona una dependencia'
                },

                departamento_id: {
                    required: 'Selecciona un departamento'
                },

                analista_id:{
                    required: 'Selecciona o agrega un analista'
                },

                proveedor_id:{
                    required: 'Selecciona o agrega un proveedor'
                },

                monto_total_aprobado: {
                    required: 'Ingresa el monto aprobado'
                },

                fecha_adjudicacion: {
                    required: 'Selecciona la fecha'
                },

                dias_entrega: {
                    required: 'Ingresa los días de entrega'
                },

                dias_credito: {
                    required: 'Ingresa los días de crédito'
                },

                tipo: {
                    required: 'Selecciona un tipo'
                },
                lugar_entrega:{
                    required: 'Especifica lugar de entrega'
                },
                descripcion_servicio:{
                    required: 'Agrega úna descipcion de servicio'
                }

            }

        });

    });
