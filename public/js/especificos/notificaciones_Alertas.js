function confirmarEliminacion({
    titulo = '¿Eliminar registro?',
    texto = 'Esta acción no se puede deshacer',
    onConfirm = null
}) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (
            result.isConfirmed &&
            typeof onConfirm === 'function'
        ) {
            onConfirm();
        }
    });
}  


function confirmarEdicion({
    titulo = '¿Editar registro?',
    texto = 'Podrás modificar los datos',
    onConfirm = null
}) {

    Swal.fire({

        title: titulo,

        text: texto,

        icon: 'question',

        showCancelButton: true,

        confirmButtonText: 'Sí, editar',

        cancelButtonText: 'Cancelar',

    }).then((result) => {

        if (
            result.isConfirmed &&
            typeof onConfirm === 'function'
        ) {

            onConfirm();

        }

    });

}