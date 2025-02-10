(function () {
  const STORAGE_KEY = "todoListNotes";

  function crearTodoList() {
    const todoTituloEl = document.getElementById("todoTitulo");
    const todoItemsEl = document.getElementById("todoItems");

    const title = todoTituloEl.value.trim();
    const itemsStr = todoItemsEl.value.trim();

    if (!title && !itemsStr) {
      alert("Por favor, ingresa un título o al menos una tarea.");
      return;
    }

    const tasks = itemsStr
      .split(",")
      .map((t) => t.trim())
      .filter((t) => t.length > 0)
      .map((taskText) => ({ text: taskText, completed: false }));

    const todoObj = {
      id: Date.now(),
      title: title || "Sin título",
      tasks: tasks,
      position: { top: 100, left: 100 }
    };

    const todoEl = createTodoElement(todoObj);
    document.getElementById("panel").appendChild(todoEl);

    saveTodoToLocalStorage(todoObj);

    todoTituloEl.value = "";
    todoItemsEl.value = "";
  }

  function createTodoElement(todoObj) {
    const container = document.createElement("div");
    container.classList.add("nota", "todo-note");
    container.style.position = "absolute";
    container.style.top = todoObj.position.top + "px";
    container.style.left = todoObj.position.left + "px";
    container.setAttribute("data-id", todoObj.id);

    // Crear el título de la todo list
    const header = document.createElement("h4");
    header.textContent = todoObj.title;
    container.appendChild(header);

    // Icono de eliminar la todo list
    const deleteListBtn = document.createElement("i");
    deleteListBtn.className = "fa fa-trash-o delete-list";
    deleteListBtn.style.cursor = "pointer";
    deleteListBtn.style.position = "absolute";
    deleteListBtn.style.top = "10px";
    deleteListBtn.style.right = "10px";
    deleteListBtn.addEventListener("click", function () {
      container.remove(); // Elimina el contenedor de la lista completa
      removeTodoFromLocalStorage(todoObj.id); // Elimina la todo list del localStorage
    });
    container.appendChild(deleteListBtn);

    const ul = document.createElement("ul");
    todoObj.tasks.forEach((task, taskIndex) => {
      const li = document.createElement("li");

      const checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.checked = task.completed;
      checkbox.addEventListener("change", function () {
        task.completed = this.checked;
        span.style.textDecoration = this.checked ? "line-through" : "none";
        updateTodoInLocalStorage(todoObj);
      });
      li.appendChild(checkbox);

      const span = document.createElement("span");
      span.textContent = " " + task.text;
      if (task.completed) {
        span.style.textDecoration = "line-through";
      }
      li.appendChild(span);

      // Icono de editar tarea
      const editBtn = document.createElement("i");
      editBtn.className = "fa fa-pencil edit-task";
      editBtn.style.cursor = "pointer";
      editBtn.style.marginLeft = "10px";
      editBtn.addEventListener("click", function () {
        const newTaskText = prompt("Edita la tarea:", task.text);
        if (newTaskText !== null && newTaskText.trim() !== "") {
          task.text = newTaskText.trim();
          span.textContent = " " + task.text;
          updateTodoInLocalStorage(todoObj);
        }
      });
      li.appendChild(editBtn);

      // Icono de eliminar tarea
      const deleteTaskBtn = document.createElement("i");
      deleteTaskBtn.className = "fa fa-trash-o delete-task";
      deleteTaskBtn.style.cursor = "pointer";
      deleteTaskBtn.style.marginLeft = "10px"; // Para separarlo del icono de editar
      deleteTaskBtn.addEventListener("click", function () {
        todoObj.tasks.splice(taskIndex, 1); // Eliminar la tarea de la lista
        li.remove(); // Eliminar la tarea del DOM
        updateTodoInLocalStorage(todoObj); // Actualizar en localStorage
      });
      li.appendChild(deleteTaskBtn);

      ul.appendChild(li);
    });
    container.appendChild(ul);

    makeDraggable(container, todoObj);

    return container;
  }

  function makeDraggable(element, todoObj) {
    let initialX, initialY;

    element.addEventListener("mousedown", dragStart);

    function dragStart(e) {
      initialX = e.clientX;
      initialY = e.clientY;
      document.addEventListener("mousemove", dragging);
      document.addEventListener("mouseup", dragEnd);
    }

    function dragging(e) {
      e.preventDefault();
      const offsetX = e.clientX - initialX;
      const offsetY = e.clientY - initialY;
      let newTop = element.offsetTop + offsetY;
      let newLeft = element.offsetLeft + offsetX;
      element.style.top = newTop + "px";
      element.style.left = newLeft + "px";
      initialX = e.clientX;
      initialY = e.clientY;
    }

    function dragEnd() {
      document.removeEventListener("mousemove", dragging);
      document.removeEventListener("mouseup", dragEnd);
      todoObj.position.top = element.offsetTop;
      todoObj.position.left = element.offsetLeft;
      updateTodoInLocalStorage(todoObj);
    }
  }

  function getTodosFromLocalStorage() {
    const todosStr = localStorage.getItem(STORAGE_KEY);
    return todosStr ? JSON.parse(todosStr) : [];
  }

  function saveTodosToLocalStorage(todos) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(todos));
  }

  function saveTodoToLocalStorage(todoObj) {
    const todos = getTodosFromLocalStorage();
    todos.push(todoObj);
    saveTodosToLocalStorage(todos);
  }

  function updateTodoInLocalStorage(todoObj) {
    const todos = getTodosFromLocalStorage();
    const index = todos.findIndex((t) => t.id === todoObj.id);
    if (index > -1) {
      todos[index] = todoObj;
      saveTodosToLocalStorage(todos);
    }
  }

  function removeTodoFromLocalStorage(id) {
    let todos = getTodosFromLocalStorage();
    todos = todos.filter((t) => t.id !== id);
    saveTodosToLocalStorage(todos);
  }

  function loadTodoLists() {
    const todos = getTodosFromLocalStorage();
    todos.forEach((todoObj) => {
      const todoEl = createTodoElement(todoObj);
      document.getElementById("panel").appendChild(todoEl);
    });
  }

  window.crearTodoList = crearTodoList;

  window.addEventListener("DOMContentLoaded", loadTodoLists);
})();
