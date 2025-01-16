window.onload = function() {
    // Seleccionamos el enlace por su ID
    var enlace = document.getElementById('delete');

    // Añadimos un event listener para el evento 'click'
    enlace.addEventListener('click', function(event) {
        // Mostramos un cuadro de confirmación
        var confirmacion = confirm("¿Estás seguro de que quieres borrar esta entrada? Será irreversible");

        // Si el usuario no confirma, prevenimos la acción por defecto (seguir el enlace)
        if (!confirmacion) {
            event.preventDefault();
        }
    });
}