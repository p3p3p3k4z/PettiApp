var arrayTodoLists = [];

window.onload = () => {
  if (localStorage.getItem("todoLists")) {
    arrayTodoLists = JSON.parse(localStorage.getItem("todoLists"));
    renderTodoLists();
  }
};

function crearTodoList() {
  const nuevaLista = {
    id: 'todo-' + Date.now(),
    titulo: document.getElementById('todoTitulo').value,
    items: document.getElementById('todoItems').value.split(',').map(item => item.trim()),
    x: Math.random() * (window.innerWidth - 300),
    y: Math.random() * (window.innerHeight - 200)
  };
  
  arrayTodoLists.push(nuevaLista);
  localStorage.setItem("todoLists", JSON.stringify(arrayTodoLists));
  renderTodoLists();
  document.getElementById('todoTitulo').value = '';
  document.getElementById('todoItems').value = '';
}

function renderTodoLists() {
  const panel = document.getElementById('panel');
  const existingTodos = panel.querySelectorAll('.postit-todo');
  existingTodos.forEach(todo => todo.remove());

  arrayTodoLists.forEach(list => {
    const todoDiv = document.createElement('div');
    todoDiv.className = 'postit-todo';
    todoDiv.style.left = list.x + 'px';
    todoDiv.style.top = list.y + 'px';
    todoDiv.setAttribute('data-id', list.id);
    todoDiv.setAttribute('onmousedown', 'moverNota(event)');

    const controls = document.createElement('div');
    controls.className = 'todo-controls';
    
    const editBtn = document.createElement('i');
    editBtn.className = 'fa fa-pencil';
    editBtn.onclick = () => editarTodoList(list.id);
    
    const deleteBtn = document.createElement('i');
    deleteBtn.className = 'fa fa-trash';
    deleteBtn.onclick = () => eliminarTodoList(list.id);

    controls.appendChild(editBtn);
    controls.appendChild(deleteBtn);

    const title = document.createElement('div');
    title.className = 'todo-title';
    title.textContent = list.titulo;

    const listUl = document.createElement('ul');
    list.items.forEach(item => {
      const li = document.createElement('li');
      li.textContent = item;
      listUl.appendChild(li);
    });

    todoDiv.appendChild(controls);
    todoDiv.appendChild(title);
    todoDiv.appendChild(listUl);
    panel.appendChild(todoDiv);
  });
}

function editarTodoList(id) {
  const list = arrayTodoLists.find(t => t.id === id);
  document.getElementById('todoTitulo').value = list.titulo;
  document.getElementById('todoItems').value = list.items.join(', ');
  
  const index = arrayTodoLists.findIndex(t => t.id === id);
  arrayTodoLists.splice(index, 1);
  localStorage.setItem("todoLists", JSON.stringify(arrayTodoLists));
  renderTodoLists();
}

function eliminarTodoList(id) {
  arrayTodoLists = arrayTodoLists.filter(t => t.id !== id);
  localStorage.setItem("todoLists", JSON.stringify(arrayTodoLists));
  renderTodoLists();
}

function limpiarLocalStorage() {
  localStorage.removeItem("todoLists");
  arrayTodoLists = [];
  renderTodoLists();
}