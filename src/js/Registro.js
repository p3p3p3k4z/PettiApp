document.addEventListener('DOMContentLoaded', function () {
    const inputDivs = [
        document.getElementById('input-firstName'),
        document.getElementById('input-password'),
        document.getElementById('input-age'),
        document.getElementById('input-phone'),
        document.getElementById('input-address'),
        document.getElementById('input-area'),
        document.getElementById('fin')
    ];

    const nextButtons = [
        document.getElementById('nextBtn1'),
        document.getElementById('nextBtn2'),
        document.getElementById('nextBtn3'),
        document.getElementById('nextBtn4'),
        document.getElementById('nextBtn5'),
        document.getElementById('nextBtn6')
    ];

    async function handleNextButton(index) {
        const currentInput = inputDivs[index].querySelector('input');
        const errorMessage = document.getElementById(currentInput.name + 'Error');
        if (currentInput.name === 'area') {
            if (currentInput.value === '') {
                errorMessage.style.display = 'block';
                currentInput.classList.add('error');
                return;
            }
        }
        // Verificar si el campo está vacío o inválido
        if (currentInput.value.trim() === '') {
            errorMessage.style.display = 'block';
            currentInput.classList.add('error');
            return;
        }
    
        // Validación de edad entre 18 y 65
        if (currentInput.name === 'age') {
            const age = parseInt(currentInput.value);
            if (isNaN(age) || age < 18 || age > 65) {
                errorMessage.style.display = 'block';
                currentInput.classList.add('error');
                return;
            }
        }

        // Si estamos en el paso 4, verificar si el teléfono existe
        if (index == 3) {
            const phone = currentInput.value;  // Obtén el valor del teléfono
            const phoneExists = await checkPhoneExists(phone);  // Espera a que la función asíncrona termine
            
            console.log('Respuesta del servidor:', phoneExists);  // Agregar un log aquí
    
            if (!phoneExists) {
                inputDivs[index].style.display = 'none';
                if (inputDivs[index + 1]) {
                    inputDivs[index + 1].style.display = 'flex';
                }
            } else {
                errorMessage.style.display = 'block';
                currentInput.classList.add('error');
                phoneErrorMessage.textContent = 'El número ya está registrado.';
                return;
            }
        } else {
            // Si no es el paso 4, solo avanza sin verificar el teléfono
            if (inputDivs[index + 1]) {
                inputDivs[index].style.display = 'none';
                inputDivs[index + 1].style.display = 'flex';
            }
        }
    
        // Si es el último paso, cambiar el mensaje
        if (index === nextButtons.length - 1) {
            const h2 = document.querySelector('h2');
            const h1 = document.getElementById('fin');
            h2.style.display = 'none';
            h1.style.display = 'block';
        }
    }
    

    nextButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => handleNextButton(index));
    });

    const inputs = document.querySelectorAll('input');
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

        // Validación de edad entre 18 y 65
        if (input.name === 'age') {
            const age = parseInt(input.value);
            if (isNaN(age) || age < 18 || age > 65) {
                errorMessage.style.display = 'block';
                input.classList.add('error');
            } else {
                errorMessage.style.display = 'none';
                input.classList.remove('error');
            }
        }
    }

    inputs.forEach(input => {
        input.addEventListener('focus', function (event) {
            const errorMessage = document.getElementById(input.name + 'Error');
            errorMessage.style.display = 'none';
            input.classList.remove('error');
        });

        input.addEventListener('blur', handleBlur);
    });

    const phoneInput = document.getElementById('phone');
    const phoneErrorMessage = document.getElementById('phoneError');
    
    phoneInput.addEventListener('input', function () {
        let value = phoneInput.value;
        if (value.startsWith('MX +52 ')) {
            value = value.slice(7);
        }

        let cleanValue = value.replace(/\D/g, '');
        phoneInput.value = 'MX +52 ' + cleanValue;

        if (cleanValue.length === 10) {
            phoneErrorMessage.style.display = 'none';
            phoneInput.classList.remove('error');
        } else {
            phoneErrorMessage.style.display = 'block';
            phoneInput.classList.add('error');
        }
    });


    // Función para verificar si el teléfono ya existe en la base de datos
    async function checkPhoneExists(phone) {
        const response = await fetch('../php/Registro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ phone: phone })
        });
        const data = await response.json();
        return data.exists === true; // Devuelve un booleano si el teléfono existe o no
    }

    document.getElementById('nextBtn6').addEventListener('click', function () {
        const formData = {
            firstName: document.getElementById('firstName').value,
            password: document.getElementById('password').value,
            age: document.getElementById('age').value,
            address: document.getElementById('address').value,
            phone: document.getElementById('phone').value,
            area: document.getElementById('area').value,
            action: 'register'
        };

        sendDataToServer(formData);
    });

    function sendDataToServer(data) {
        fetch('../php/Registro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log(result);
            if (result.success) {
                alert('¡Registro exitoso!');
                window.location.href = './Login.html';
            } else {
                alert('Hubo un error al registrar los datos.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error en la conexión con el servidor.');
        });
    }
});
