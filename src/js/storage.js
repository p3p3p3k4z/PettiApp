// Funciones para interactuar con localStorage

function guardarEnStorage(clave, datos) {
    localStorage.setItem(clave, JSON.stringify(datos));
}

function obtenerDesdeStorage(clave) {
    return JSON.parse(localStorage.getItem(clave)) || null;
}

function eliminarDeStorage(clave) {
    localStorage.removeItem(clave);
}

function limpiarLocalStorage() {
    localStorage.clear();
    location.reload();
}
