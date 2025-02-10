// Clase Nota
class Nota {
  constructor(id, titulo, texto, fecha, left = 0, top = 0) {
    this.id = id;
    this.titulo = titulo;
    this.texto = texto;
    this.fecha = fecha;
    this.left = left;  // Posición en el eje X
    this.top = top;    // Posición en el eje Y
  }
}

var contId = 0;
var arrayNotas = [];

window.onload = () => {
  if (localStorage.getItem("notas") != null) {
    arrayNotas = JSON.parse(localStorage.getItem("notas"));
    vistaNotas();
  }
}

function vistaNotas() {
  for (var i = 0; i < arrayNotas.length; i++) {
    var id = arrayNotas[i].id;
    contId = id.substr(4, id.length);

    var panel = document.getElementById("panel");

    var divNota = document.createElement("div");
    divNota.setAttribute("id", "nota" + contId);
    divNota.setAttribute("class", "postit");
    divNota.setAttribute("style", `height:auto;width:200px;left:${arrayNotas[i].left}px;top:${arrayNotas[i].top}px`);
    divNota.setAttribute("onmousedown", "moverNota(event)");

    var divCerrar = document.createElement("div");
    divCerrar.setAttribute("align", "right");

    var divCruz = document.createElement("a");
    divCruz.setAttribute("class", "fa fa-times");
    divCruz.setAttribute("onclick", "cerrarNota(event)");
    divCruz.setAttribute("style", "color:red");

    var divEditar = document.createElement("a");
    divEditar.setAttribute("class", "fa fa-pencil editar" + contId);
    divEditar.setAttribute("data-toggle", "modal");
    divEditar.setAttribute("data-target", "#modelPost-itEditar");
    divEditar.setAttribute("onclick", "getIdNota(event)");
    divEditar.setAttribute("style", "color:black");

    var divTitulo = document.createElement("p");
    divTitulo.setAttribute("class", "titulo titulo" + contId);
    divTitulo.setAttribute("style", "font-weight:bold;");
    divTitulo.textContent = arrayNotas[i].titulo;

    var divTexto = document.createElement("p");
    divTexto.setAttribute("class", "texto texto" + contId);
    divTexto.setAttribute("style", "word-wrap:break-word");
    divTexto.textContent = arrayNotas[i].texto;

    var divFecha = document.createElement("p");
    divFecha.setAttribute("class", "fecha fecha" + contId);
    divFecha.setAttribute("style", "visibility:hidden");
    divFecha.textContent = " min";

    divCerrar.appendChild(divEditar);
    divCerrar.appendChild(divCruz);
    divNota.appendChild(divCerrar);
    divNota.appendChild(divTitulo);
    divNota.appendChild(divTexto);
    divNota.appendChild(divFecha);
    panel.appendChild(divNota);
  }
}

function crear() {
  const titulo = document.getElementById('ModalTituloCrear').value;
  const texto = document.getElementById('ModalTextoCrear').value;

  // Verificamos que el título y el texto no estén vacíos
  if (titulo.trim() === "" || texto.trim() === "") {
    alert("No puedes crear una nota vacía");
    return;
  }

  contId++;
  var panel = document.getElementById("panel");

  var divNota = document.createElement("div");
  divNota.setAttribute("id", "nota" + contId);
  divNota.setAttribute("class", "postit");
  divNota.setAttribute("onmousedown", "moverNota(event)");

  var divCerrar = document.createElement("div");
  divCerrar.setAttribute("align", "right");

  var divCruz = document.createElement("a");
  divCruz.setAttribute("class", "fa fa-times");
  divCruz.setAttribute("onclick", "cerrarNota(event)");
  divCruz.setAttribute("style", "color:red");

  var divEditar = document.createElement("a");
  divEditar.setAttribute("class", "fa fa-pencil editar editar" + contId);
  divEditar.setAttribute("data-toggle", "modal");
  divEditar.setAttribute("data-target", "#modelPost-itEditar");
  divEditar.setAttribute("onclick", "getIdNota(event)");
  divEditar.setAttribute("style", "color:black");

  var divTitulo = document.createElement("p");
  divTitulo.setAttribute("class", "titulo titulo" + contId);
  divTitulo.setAttribute("style", "font-weight:bold;");
  divTitulo.textContent = titulo;

  var divTexto = document.createElement("p");
  divTexto.setAttribute("class", "texto texto" + contId);
  divTexto.setAttribute("style", "word-wrap:break-word");
  divTexto.textContent = texto;

  var divFecha = document.createElement("p");
  divFecha.setAttribute("class", "fecha fecha" + contId);
  divFecha.setAttribute("style", "visibility:hidden");
  divFecha.textContent = " min";

  divCerrar.appendChild(divEditar);
  divCerrar.appendChild(divCruz);
  divNota.appendChild(divCerrar);
  divNota.appendChild(divTitulo);
  divNota.appendChild(divTexto);
  divNota.appendChild(divFecha);
  panel.appendChild(divNota);

  // Agregar la nueva nota al array y al localStorage
  var fecha = new Date();
  arrayNotas.push(new Nota("nota" + contId, titulo, texto, fecha));
  localStorage.setItem("notas", JSON.stringify(arrayNotas));

  document.getElementById('ModalTituloCrear').value = "";
  document.getElementById('ModalTextoCrear').value = "";
}

function moverNota(evento) {
  try {
    var notaSeleccionada = evento.target.id;
    id = document.getElementById(notaSeleccionada);
    id.style.position = 'absolute';
    id.style.zIndex = 1000;

    document.body.append(id);

    function moveAt(pageX, pageY) {
      id.style.left = pageX - id.offsetWidth / 2 + 'px';
      id.style.top = pageY - id.offsetHeight / 2 + 'px';
    }

    moveAt(event.pageX, event.pageY);

    function onMouseMove(event) {
      moveAt(event.pageX, event.pageY);
    }

    document.addEventListener('mousemove', onMouseMove);

    id.onmouseup = function () {
      document.removeEventListener('mousemove', onMouseMove);
      id.onmouseup = null;

      // Actualizamos la posición en el array y localStorage
      var nota = arrayNotas.find(nota => nota.id === notaSeleccionada);
      if (nota) {
        nota.left = id.offsetLeft;
        nota.top = id.offsetTop;
        localStorage.setItem("notas", JSON.stringify(arrayNotas));
      }
    };
  } catch (e) {
    console.log(e);
  }
}

function cerrarNota(evento) {
  var id = evento.target.parentNode.parentNode.id;
  document.getElementById(id).remove();

  for (var i = 0; i < arrayNotas.length; i++) {
    if (id == arrayNotas[i].id) {
      arrayNotas.splice(i, 1);
    }
  }
  localStorage.setItem("notas", JSON.stringify(arrayNotas));
}

function getIdNota(evento) {
  return evento.target.parentNode.parentNode.id;
}

// limpiar.js
function limpiarLocalStorage() {
    // Elimina todo el contenido del localStorage
    localStorage.clear();
    // Recarga la página
    location.reload();
}

// Función para obtener el ID de la nota cuando se hace clic en el botón de editar
function getIdNota(evento) {
  var notaId = evento.target.parentNode.parentNode.id;  // Obtener el ID de la nota
  // Pasamos el ID a la función de editar
  editarNotas(notaId);
}

function editarNotas(id) {
  var fech = new Date();
  for (var i = 0; i < arrayNotas.length; i++) {
    if (id == arrayNotas[i].id) {
      // Obtener los elementos de la nota seleccionada
      var titulo = document.getElementsByClassName("titulo" + id.substr(4, id.length));
      var texto = document.getElementsByClassName("texto" + id.substr(4, id.length));
      
      // Actualizar los textos con los nuevos valores del modal
      titulo[0].textContent = document.getElementById('ModalTituloEditar').value;
      texto[0].textContent = document.getElementById('ModalTextoEditar').value;
      
      // Actualizar la nota en el array con la nueva información
      arrayNotas[i] = new Nota(id, titulo[0].textContent, texto[0].textContent, fech);
      
      // Limpiar los valores del modal
      document.getElementById('ModalTituloEditar').value = "";
      document.getElementById('ModalTextoEditar').value = "";
    }
  }

  // Guardamos el array de notas actualizado en el localStorage
  localStorage.setItem("notas", JSON.stringify(arrayNotas));
}

