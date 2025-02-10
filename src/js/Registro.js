document.addEventListener('DOMContentLoaded', function () {
    // Incluimos todos los contenedores de campos en el orden que se muestran
    const inputDivs = [
      document.getElementById('input-firstName'),
      document.getElementById('input-password'),
      document.getElementById('input-age'),
      document.getElementById('input-phone'),
      document.getElementById('input-address'),
      document.getElementById('input-area'),
      document.getElementById('fin')
    ];
  
    // Los botones "Siguiente" en cada paso (según el HTML)
    const nextButtons = [
      document.getElementById('nextBtn1'),
      document.getElementById('nextBtn2'),
      document.getElementById('nextBtn3'),
      document.getElementById('nextBtn4'),
      document.getElementById('nextBtn5'),
      document.getElementById('nextBtn6')
    ];
  
    // Función para manejar la validación y avance al siguiente paso
    async function handleNextButton(index) {
      const currentInput = inputDivs[index].querySelector('input, select');
      const errorMessage = document.getElementById(currentInput.name + 'Error');
  
      // Verificar que el campo no esté vacío
      if (currentInput.value.trim() === '') {
        errorMessage.style.display = 'block';
        currentInput.classList.add('error');
        return;
      }
  
      // Validación especial para el teléfono
      if (currentInput.name === 'phone') {
        const phone = currentInput.value.replace(/\D/g, ''); // Quitar caracteres no numéricos
        if (phone.length !== 10) {
          errorMessage.style.display = 'block';
          errorMessage.textContent = 'El número debe tener 10 dígitos.';
          currentInput.classList.add('error');
          return;
        }
        // Verificar si el teléfono ya está registrado
        const phoneExists = await checkPhoneExists(phone);
        if (phoneExists) {
          errorMessage.style.display = 'block';
          errorMessage.textContent = 'El número ya está registrado.';
          currentInput.classList.add('error');
          return;
        }
      }
  
      // Validación para el área: debe ser uno de los valores permitidos
      if (currentInput.name === 'area' && !['barra', 'admin', 'repartidor'].includes(currentInput.value)) {
        errorMessage.style.display = 'block';
        errorMessage.textContent = 'Área no válida.';
        currentInput.classList.add('error');
        return;
      }
  
      // Avanzar al siguiente campo
      if (inputDivs[index + 1]) {
        inputDivs[index].style.display = 'none';
        inputDivs[index + 1].style.display = 'block';
      }
  
      // Si es el último botón (campo área), mostrar mensaje final y enviar datos al servidor
      if (index === nextButtons.length - 1) {
        document.querySelector('h2').style.display = 'none';
        document.getElementById('fin').style.display = 'block';
        sendRegistrationData();
      }
    }
  
    // Asignar evento click a cada botón "Siguiente"
    nextButtons.forEach((btn, index) => {
      btn.addEventListener('click', () => handleNextButton(index));
    });
  
    // Eliminar mensajes de error al enfocar el campo
    document.querySelectorAll('input, select').forEach(input => {
      input.addEventListener('focus', function () {
        const errorMessage = document.getElementById(input.name + 'Error');
        errorMessage.style.display = 'none';
        input.classList.remove('error');
      });
    });
  
    // Función para verificar si el teléfono ya existe en la BD
    async function checkPhoneExists(phone) {
      try {
        const response = await fetch('../php/Registro.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ phone: phone, action: 'checkPhone' })
        });
        const data = await response.json();
        return data.exists === true;
      } catch (error) {
        console.error('Error al verificar el teléfono:', error);
        return false;
      }
    }
  
    // Función para enviar los datos de registro (solo los campos necesarios)
    function sendRegistrationData() {
      const formData = {
        nombre: document.getElementById('firstName').value,
        password: document.getElementById('password').value, // se guarda en texto plano
        phone: document.getElementById('phone').value.replace(/\D/g, ''),
        area: document.getElementById('area').value,
        action: 'register'
      };
  
      fetch('../php/Registro.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
      })
        .then(response => response.json())
        .then(result => {
          if (result.success) {
            alert('¡Registro exitoso!');
            window.location.href = './Login.html';
          } else {
            alert('Error en el registro: ' + result.message);
          }
        })
        .catch(error => console.error('Error:', error));
    }
  });
  