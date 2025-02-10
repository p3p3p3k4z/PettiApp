document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input');
    const loginForm = document.getElementById('loginForm');
    const phoneInput = document.getElementById('phone');
    const passwordInput = document.getElementById('password');
    const submitError = document.getElementById('submiterror');
    const submitButton = loginForm.querySelector('button');
    const container = document.querySelector('.container');
    
    let failedAttempts = 0;  
    const maxAttempts = 3;  
    const specialPassword = '@seguro';
    
    const unlockButton = document.getElementById('unlockButtonCreated');  
    unlockButton.style.display = 'none';  

    function handleBlur(event) {
        const input = event.target;
        const errorMessage = document.getElementById(input.name + 'Error');
        
        if (input.value.trim() === '') {
            errorMessage.style.display = 'block';
            input.classList.add('error');
        } else {
            errorMessage.style.display = 'none';
            input.classList.remove('error');
        }
    }

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            const errorMessage = document.getElementById(input.name + 'Error');
            errorMessage.style.display = 'none';
            input.classList.remove('error');
        });

        input.addEventListener('blur', handleBlur);
    });

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        if (submitButton.disabled) {
            alert("Demasiados intentos fallidos. Intenta con la contraseña especial.");
            return;
        }

        const phone = phoneInput.value.trim();
        const password = passwordInput.value.trim();

        if (!phone || !password) {
            alert('Por favor, ingresa todos los campos.');
            return;
        }

        if (!/^\d+$/.test(phone)) {
            alert('El teléfono debe contener solo números.');
            return;
        }

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
                window.location.href = data.redirectUrl;
            } else {
                failedAttempts++;
                submitError.textContent = data.message;
                submitError.style.display = 'block';

                if (failedAttempts >= maxAttempts) {
                    submitButton.disabled = true;
                    alert("Has superado el límite de intentos fallidos. Ingresa la contraseña especial para desbloquear.");
                    
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

    unlockButton.addEventListener('click', function () {
        const specialPasswordInput = prompt("Ingresa la contraseña especial para desbloquear el botón:");

        if (specialPasswordInput === specialPassword) {
            failedAttempts = 0;
            submitButton.disabled = false;
            submitError.style.display = 'none';
            alert("Botón desbloqueado. Ahora puedes intentar iniciar sesión de nuevo.");

            unlockButton.style.display = 'none'; 
            container.style.display = 'block'; 
        } else {
            alert("Contraseña incorrecta.");
        }
    });

    phoneInput.addEventListener('input', () => submitError.style.display = 'none');
    passwordInput.addEventListener('input', () => submitError.style.display = 'none');
});
