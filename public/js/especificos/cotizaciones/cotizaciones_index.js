function eliminarCotizacion(id) {
    confirmarEliminacion({
        titulo: '¿Eliminar Cotizacion?',
        onConfirm: () => {
            document
                .getElementById('delete-form-' + id)
                ?.submit();
        }
    });
}