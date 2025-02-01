document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input');
    const loginForm = document.getElementById('loginForm');
    const phoneInput = document.getElementById('phone');
    const passwordInput = document.getElementById('password');
    const submitError = document.getElementById('submiterror');
    const submitButton = loginForm.querySelector('button');
    const container = document.querySelector('.container');  // Seleccionamos el contenedor

    let failedAttempts = 0;  // Contador de intentos fallidos
    const maxAttempts = 3;   // Número máximo de intentos fallidos
    const specialPassword = '@seguro';  // Contraseña especial para desbloquear
    const unlockButton = document.getElementById('unlockButtonCreated');  // El botón ya presente en el HTML
    unlockButton.style.display = 'none';  // Aseguramos que el botón esté oculto al principio

    // Función para manejar cuando se desenfoca el input
    function handleBlur(event) {
        const input = event.target;
        const errorMessage = document.getElementById(input.name + 'Error'); // Obtener el mensaje de error correspondiente
        
        // Verifica si el input está vacío después de desenfocarse
        if (input.value === '') {
            console.log(`${input.name} no tiene texto después de desenfocarse.`);
            // Mostrar el mensaje de error correspondiente
            errorMessage.style.display = 'block'; // Muestra el mensaje de error
            input.classList.add('error'); // Añade una clase de error para estilizar el input
        } else {
            // Si se escribió algo, aseguramos que no se vea el mensaje de error
            errorMessage.style.display = 'none'; // Oculta el mensaje de error
            input.classList.remove('error'); // Elimina la clase de error
        }
    }

    // Añadir evento focus a cada input
    inputs.forEach(input => {
        input.addEventListener('focus', function(event) {
            // Elimina cualquier mensaje de error al enfocar el input
            const errorMessage = document.getElementById(input.name + 'Error');
            errorMessage.style.display = 'none';
            input.classList.remove('error');
        });

        // Añadir evento blur para detectar cuando el input pierde el foco
        input.addEventListener('blur', handleBlur);
    });

    // Evento al enviar el formulario de login
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Evita el comportamiento por defecto del formulario (recarga de la página)

        // Verificar si el botón está deshabilitado
        if (submitButton.disabled) {
            alert("Demasiados intentos fallidos. Intenta con la contraseña especial.");
            return;
        }

        const phone = phoneInput.value.trim();
        const password = passwordInput.value.trim();

        // Validación básica de los campos
        if (!phone || !password) {
            alert('Por favor, ingresa todos los campos.');
            return;
        }

        // Hacer la solicitud al servidor para verificar el login
        fetch('../php/Login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ phone, password })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Si la autenticación es exitosa, redirigir a la nueva página
                window.location.href = data.redirectUrl; // Redirige a la página según el área
            } else {
                // Si el login falla
                failedAttempts++;
                submitError.textContent = data.message; // Muestra el mensaje de error
                submitError.style.display = 'block'; // Asegúrate de que el mensaje sea visible

                // Ocultar el contenedor cuando el mensaje de error sea visible
                

                if (failedAttempts >= maxAttempts) {
                    // Si se superan los intentos fallidos, deshabilitar el botón y mostrar el de desbloqueo
                    submitButton.disabled = true;
                    alert("Has superado el límite de intentos fallidos. Ingresa la contraseña especial para desbloquear.");
                    
                    // Mostrar el botón de desbloqueo
                    container.style.display = 'none';
                    unlockButton.style.display = 'block'; 
                }
            }
        })
        .catch(error => {
            console.error('Error al hacer la solicitud de login:', error);
            alert('Hubo un error al intentar iniciar sesión. Por favor, intenta nuevamente más tarde.');
        });
    });

    // Evento para el botón de desbloqueo
    unlockButton.addEventListener('click', function () {
        const specialPasswordInput = prompt("Ingresa la contraseña especial para desbloquear el botón:");

        if (specialPasswordInput === specialPassword) {
            failedAttempts = 0; // Reiniciar el contador de intentos fallidos
            submitButton.disabled = false; // Habilitar el botón de login nuevamente
            submitError.style.display = 'none'; // Limpiar cualquier mensaje de error
            alert("Botón desbloqueado. Ahora puedes intentar iniciar sesión de nuevo.");

            // Ocultar el botón de desbloqueo
            unlockButton.style.display = 'none'; 

            // Mostrar nuevamente el contenedor
            container.style.display = 'block'; 
        } else {
            alert("Contraseña incorrecta.");
        }
    });

    // Ocultar el mensaje de error cuando el usuario empieza a escribir
    phoneInput.addEventListener('input', function () {
        submitError.style.display = 'none';
    });

    passwordInput.addEventListener('input', function () {
        submitError.style.display = 'none';
    });
});
