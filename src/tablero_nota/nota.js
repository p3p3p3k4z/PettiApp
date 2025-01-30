class Nota {
  constructor(id, titulo, texto, fecha) {
    this.id = id;
    this.titulo = titulo;
    this.texto = texto;
    this.fecha = fecha;
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
    divNota.setAttribute("style", "height:auto;width:200px");
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
    // divTitulo.setAttribute("class", "titulo");
    divTitulo.setAttribute("style", "font-weight:bold;");
    divTitulo.textContent = arrayNotas[i].titulo;

    var divTexto = document.createElement("p");
    divTexto.setAttribute("class", "texto texto" + contId);
    // divTexto.setAttribute("class", "texto");
    divTexto.setAttribute("style", "word-wrap:break-word");
    divTexto.textContent = arrayNotas[i].texto;

    var divFecha = document.createElement("p");
    divFecha.setAttribute("class", "fecha fecha" + contId);
    // divFecha.setAttribute("class", "fecha");

    var fechaNota = Date.parse(arrayNotas[i].fecha);
    var fechaActual = new Date();
    var diffMs = (fechaActual - fechaNota);
    var min = Math.round(((diffMs % 86400000) % 3600000) / 60000);
    divFecha.textContent = "🕓 " + min + " min";


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
  // divEditar.setAttribute("class", "editar");
  divEditar.setAttribute("data-toggle", "modal");
  divEditar.setAttribute("data-target", "#modelPost-itEditar");
  divEditar.setAttribute("onclick", "getIdNota(event)");
  divEditar.setAttribute("style", "color:black visibility:hidden");

  var divTitulo = document.createElement("p");
  divTitulo.setAttribute("class", "titulo titulo" + contId);
  // divTitulo.setAttribute("class", "titulo");
  divTitulo.setAttribute("style", "font-weight:bold;");
  divTitulo.textContent = document.getElementById('ModalTituloCrear').value;

  var divTexto = document.createElement("p");
  divTexto.setAttribute("class", "texto texto" + contId);
  // divTexto.setAttribute("class", "texto");
  divTexto.setAttribute("style", "word-wrap:break-word");
  divTexto.textContent = document.getElementById('ModalTextoCrear').value;

  var divFecha = document.createElement("p");
  divFecha.setAttribute("class", "fecha fecha" + contId);
  // divFecha.setAttribute("class", "fecha");
  divFecha.setAttribute("style", "visibility:hidden");
  divFecha.textContent = " min";

  divCerrar.appendChild(divEditar);
  divCerrar.appendChild(divCruz);
  divNota.appendChild(divCerrar);
  divNota.appendChild(divTitulo);
  divNota.appendChild(divTexto);
  divNota.appendChild(divFecha);
  panel.appendChild(divNota);

  document.getElementById('ModalTituloCrear').value ="";
  document.getElementById('ModalTextoCrear').value = "";
  
}



function crearNota(event) {
  var id = event.target.parentNode.id;

  var titulo = document.getElementsByClassName("titulo" + contId);
  var texto = document.getElementsByClassName("texto" + contId);
  var fecha = new Date();

  for (var i = 0; i < arrayNotas.length; i++) {
    if (id == arrayNotas[i].id) {
      arrayNotas[i].titulo = titulo[0].textContent;
      arrayNotas[i].texto = texto[0].textContent;
      arrayNotas[i].fecha = new Date();
      localStorage.setItem("notas", JSON.stringify(arrayNotas));
    }
  }

  var id = "nota" + contId;
  var titulo = document.getElementsByClassName("titulo" + contId);
  var texto = document.getElementsByClassName("texto" + contId);
  var fech = new Date();

  arrayNotas.push(new Nota(id, titulo[0].textContent, texto[0].textContent, fech));

  var fecha = document.getElementsByClassName("fecha" + contId);
  fecha[0].style.visibility = "visible";

  var fechahoy = new Date();
  var diffMs = (fechahoy - fech);
  var min = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
  fecha[0].textContent = "🕓 " + min + " min";

  localStorage.setItem("notas", JSON.stringify(arrayNotas));

}



function cerrarNota(evento) {
  var id = evento.target.parentNode.parentNode.id;
  document.getElementById("" + id + "").remove();
  for (var i = 0; i < arrayNotas.length; i++) {
    if (id == arrayNotas[i].id) {
      arrayNotas.splice(i, 1);
    }
    localStorage.setItem("notas", JSON.stringify(arrayNotas));
  }
}



function getIdNota(evento) {
  id = evento.target.parentNode.parentNode.id;
  return id;
}



function editarNotas() {
  var fech = new Date();
  for (var i = 0; i < arrayNotas.length; i++) {
    if (id == arrayNotas[i].id) {
      var titulo = document.getElementsByClassName("titulo" + id.substr(4, id.length));
      var texto = document.getElementsByClassName("texto" + id.substr(4, id.length));
      titulo[0].textContent = document.getElementById('ModalTituloEditar').value;
      texto[0].textContent = document.getElementById('ModalTextoEditar').value;
      arrayNotas.splice(i,1,new Nota(id, titulo[0].textContent, texto[0].textContent, fech));
      document.getElementById('ModalTituloEditar').value = "";
      document.getElementById('ModalTextoEditar').value = "";

    }
  }
  localStorage.setItem("notas", JSON.stringify(arrayNotas));
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
    };
  } catch (e) {
    console.log();
  }
};



function limpiarLocalStorage() {
  localStorage.clear();
  location.reload();
}
