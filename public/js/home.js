function resultMessage(message) {
  const toastLive = document.getElementById('liveToast');
  const toastLiveMessage = document.getElementById('liveMessage');
  if (toastLive && toastLiveMessage) {
    toastLiveMessage.innerHTML = message;
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
    toastBootstrap.show();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  checkNavbar();
  document.addEventListener("scroll", (event) => {
    checkNavbar();
  });
});

function checkNavbar() {
  lastKnownScrollPosition = window.scrollY;
  const nav = document.getElementById('navbar');
  const inscription = document.getElementById('navbar-inscription');
  const logo = document.getElementById('logo');
  const scrollMsg = document.getElementById('scroll-message');
  if (nav && scrollY < 2) {
    nav.classList.remove('opaque');
    inscription.classList.add('d-none');
    logo.classList.remove('black');
    scrollMsg.classList.remove('invisible');
  } else if (nav) {
    nav.classList.add('opaque');
    inscription.classList.remove('d-none');
    logo.classList.add('black');
    scrollMsg.classList.add('invisible');
  }
}

function toggleButtons(price) {
  const registerButton = document.getElementById('register-button');
  const paypalContainer = document.getElementById('paypal-button-container');

  if (price > 0) {
    registerButton.hidden = true;
    paypalContainer.hidden = false;
  } else {
    registerButton.hidden = false;
    paypalContainer.hidden = true;
  }
  const firstMessage = document.getElementById('register-message');
  if (firstMessage) {
    firstMessage.hidden = true;
  }
}