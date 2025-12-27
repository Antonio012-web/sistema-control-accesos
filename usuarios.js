// Aquí puedes agregar funciones para validación o interactividad, si lo necesitas

document.querySelector('form').addEventListener('submit', function(event) {
    const nombre = document.querySelector('[name="nombre"]').value;
    if (!nombre.trim()) {
        alert('El nombre es obligatorio');
        event.preventDefault();
    }
});
