function eliminarDependencia(id) {
    confirmarEliminacion({
        titulo: '¿Eliminar dependencia?',
        onConfirm: () => {
            document
                .getElementById('delete-form-' + id)
                ?.submit();
        }
    });
}