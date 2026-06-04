document.addEventListener('DOMContentLoaded', function () {

            const estadoSelect = document.getElementById('estadoSelect');
            const fechaGroup = document.getElementById('fechaFacturacionGroup');

            if (!estadoSelect) return;

            function toggleFechaFacturacion() {

                if (estadoSelect.value === 'facturado') {
                    fechaGroup.style.display = 'block';
                } else {
                    fechaGroup.style.display = 'none';
                }

            }

            estadoSelect.addEventListener('change', toggleFechaFacturacion);

            toggleFechaFacturacion();

        });

        function confirmUpdate(id) {
            const estado = document.getElementById('estadoSelect').value;
            Swal.fire({
                title: '¿Actualizar estado?',
                text: `El pedido pasará a: ${estado}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById('update-form-' + id);
                    if (form) {
                        form.submit();
                    }
                }
            });
        }
