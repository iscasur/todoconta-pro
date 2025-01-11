const form = document.getElementById('subscribe-form');
const messageContainer = document.getElementById('subscribe-message');

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  const name = formData.get('name') || '';
  formData.append('referrer', window.location.href);

  try {
    const response = await fetch('https://sendy.todoconta.com/subscribe', {
      method: 'POST',
      body: formData
    });

    if (response.ok) {
      const responseText = await response.text();

      if (responseText === "1") {
        form.textContent = `¡Excelente ${name}! Te has suscrito con éxito 🎉. Ahora toca ir a revisar tu correo que te he envíado un regalito 🎁.`;
        if (form instanceof HTMLFormElement) {
          form.reset();
        } else {
          console.error("The provided element is not a valid form.");
        }
      } else if (responseText === "Already subscribed.") {
        messageContainer.textContent =
          `Oye ${name}, parece que ya te habías suscrito antes 🤔`;
      } else {
        messageContainer.textContent = `Error: ${responseText}`;
      }
    }
  } catch (error) {
    console.error('Error subscribing user:', error);
    messageContainer.textContent = 'Ocurrió un error al suscribirte, intenta mas tarde';
  }
})