function subirImagen() {
    let input = document.getElementById("imagenNota");
    let file = input.files[0];

    // Verificamos que el archivo no sea vacío
    if (!file) {
        alert("Debes seleccionar una imagen.");
        return;
    }

    let reader = new FileReader();
    reader.onload = function(e) {
        crearNotaConImagen(e.target.result);
    };
    reader.readAsDataURL(file);

    // Cierra el modal
    $('#modelPost-itImagen').modal('hide');
}

function crearNotaConImagen(urlImagen) {
    let panel = document.getElementById("panel");
    let nuevaNota = document.createElement("div");

    let idNota = "nota_" + Date.now(); // ID único basado en el tiempo
    nuevaNota.classList.add("todo-note");
    nuevaNota.id = idNota;
    nuevaNota.style.position = "absolute";

    // Recuperar las notas almacenadas en localStorage
    let notasGuardadas = JSON.parse(localStorage.getItem("notes")) || {};
    
    if (notasGuardadas[idNota]) {
        let datosNota = notasGuardadas[idNota];
        nuevaNota.style.left = datosNota.left;
        nuevaNota.style.top = datosNota.top;

        // Crear la imagen desde el almacenamiento
        let imagen = document.createElement("img");
        imagen.src = datosNota.urlImagen; // Usar la URL de imagen guardada
        imagen.classList.add("note-image");
        nuevaNota.appendChild(imagen);
    } else {
        // Si no existe información en localStorage, establecer una posición inicial
        nuevaNota.style.left = "100px";
        nuevaNota.style.top = "100px";
        let imagen = document.createElement("img");
        imagen.src = urlImagen;
        imagen.classList.add("note-image");
        nuevaNota.appendChild(imagen);
    }

    let botonEliminar = document.createElement("span");
    botonEliminar.innerHTML = "❌";
    botonEliminar.classList.add("delete-note");
    botonEliminar.onclick = function() {
        panel.removeChild(nuevaNota);
        delete notasGuardadas[idNota]; // Eliminar la nota del objeto de almacenamiento
        localStorage.setItem("notes", JSON.stringify(notasGuardadas)); // Guardar el objeto actualizado
    };

    // Agregar funcionalidad de arrastrar
    nuevaNota.onmousedown = function (evento) {
        moverNotaConImagen(evento, nuevaNota, idNota, urlImagen, notasGuardadas);
    };

    nuevaNota.appendChild(botonEliminar);
    panel.appendChild(nuevaNota);

    // Guardar la nueva nota en localStorage
    notasGuardadas[idNota] = { left: nuevaNota.style.left, top: nuevaNota.style.top, urlImagen: urlImagen };
    localStorage.setItem("notes", JSON.stringify(notasGuardadas));
}

function moverNotaConImagen(evento, nota, idNota, urlImagen, notasGuardadas) {
    evento.preventDefault(); // Prevenir selección de texto u otros comportamientos predeterminados

    let desplazamientoX = evento.clientX - nota.getBoundingClientRect().left;
    let desplazamientoY = evento.clientY - nota.getBoundingClientRect().top;

    function enMovimiento(evento) {
        // Actualizar la posición de la nota mientras se arrastra
        nota.style.left = evento.clientX - desplazamientoX + 'px';
        nota.style.top = evento.clientY - desplazamientoY + 'px';
    }

    // Habilitar el movimiento mientras el ratón esté presionado
    document.addEventListener('mousemove', enMovimiento);

    // Cuando se suelta el ratón, detener el movimiento y guardar la nueva posición
    document.onmouseup = function() {
        document.removeEventListener('mousemove', enMovimiento);
        document.onmouseup = null; // Deshabilitar el evento de "mouseup"

        // Guardar la nueva posición en el objeto de notas
        notasGuardadas[idNota] = { left: nota.style.left, top: nota.style.top, urlImagen: urlImagen };
        localStorage.setItem("notes", JSON.stringify(notasGuardadas));
    };
}
