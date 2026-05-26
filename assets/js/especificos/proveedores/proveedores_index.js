function eliminarProveedor(id) {
    confirmarEliminacion({
        titulo: '¿Eliminar proveedor?',
        onConfirm: () => {
            document
                .getElementById('delete-form-' + id)
                ?.submit();
        }
    });
}   