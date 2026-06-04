function confirmDelete(id) {
    confirmarEliminacion({
        titulo: '¿Eliminar pedido?',
        onConfirm: () => {
            document
                .getElementById('delete-form-' + id)
                ?.submit();
        }
    });
}