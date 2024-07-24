$(() => {
  fetch('http://localhost:8080/prueba', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ username: 'root', password: 'root' })
})
.then(response => response.json())
.then(data => console.log('Success:', data))
.catch((error) => console.error('Error:', error));
})

let recaptchaValid = false;

function validateReCaptcha(token){
  recaptchaValid = true;
}

function onRecaptchaExpired() {
  recaptchaValid = false;
  alert('El token de reCAPTCHA ha expirado. Por favor, complétalo nuevamente.');
}

async function onSubmit(event) {
  if (!recaptchaValid) {
    event.preventDefault();
    return alert('Por favor, completa el reCAPTCHA.');
  }
}