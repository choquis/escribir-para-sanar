
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
});

function checkNavbar() {
  lastKnownScrollPosition = window.scrollY;
  const nav = document.getElementById('navbar');
  const logo = document.getElementById('logo');
  nav.classList.add('opaque');
  logo.classList.add('black');
}