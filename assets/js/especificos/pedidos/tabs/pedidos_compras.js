function eliminarCompra(id) {
    confirmarEliminacion({
        titulo: '¿Eliminar compra?',
        onConfirm: () => {
            document
                .getElementById('delete-form-' + id)
                ?.submit();
        }
    });
}

function editarCompra(url) {
    confirmarEdicion({
        titulo: '¿Editar compra?',
        texto: 'Podrás modificar los datos',
        onConfirm: () => {
            window.location.href = url;
        }
    });
}