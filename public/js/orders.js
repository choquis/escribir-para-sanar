const debounce = (mainFunction, delay) => {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      mainFunction(...args);
    }, delay);
  };
};

function resultMessage(message) {
  const toastLive = document.getElementById('liveToast');
  const toastLiveMessage = document.getElementById('liveMessage');
  if (toastLive && toastLiveMessage) {
    toastLiveMessage.innerHTML = message;
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
    toastBootstrap.show();
  }
}

function toggleSpinner() {
  const spinners = document.getElementsByClassName("spinner-container");
  for (let i = 0; i < spinners.length; i++) {
    spinners[i].classList.toggle("d-none");
  }
}

function removeOptions(selectElement) {
  var i, L = selectElement.options.length - 1;
  for (i = L; i >= 0; i--) {
    selectElement.remove(i);
  }
}

function inputKeyupEvent(e) {
  debouncedEventSearchData();
}

function inputKeyupEmail(e) {
  debouncedEmailSearchData();
}

function selectEvent() {
  const select = document.getElementById('eventList');
  if (select == null) return;
  if (select.options.length <= 0 || select.selectedIndex < 0) return;

  let id = select.options[select.selectedIndex].value;
  let name = select.options[select.selectedIndex].dataset?.name;

  const inputName = document.getElementById('event_name');
  const inputId = document.getElementById('event_id');

  if (inputId) inputId.value = id;
  if (inputName) inputName.value = name;

  if (eventModal == null) return;
  eventModal.hide();
}
function selectEmail() {
  const select = document.getElementById('emailList');
  if (select == null) return;
  if (select.options.length <= 0 || select.selectedIndex < 0) return;

  let id = select.options[select.selectedIndex].value;
  let name = select.options[select.selectedIndex].dataset?.name;

  const inputName = document.getElementById('email');
  const inputId = document.getElementById('email_id');

  if (inputId) inputId.value = id;
  if (inputName) inputName.value = name;
  if (emailModal == null) return;

  emailModal.hide();
}

function openEventModal() {
  if (eventModal == null) return;
  eventModal.show();
}

function openEventEmail() {
  if (emailModal == null) return;
  emailModal.show();
}

async function searchEvent() {
  let searchEventName = document.getElementById('searchEventName').value;
  toggleSpinner();
  try {
    const response = await fetch(`/api/eventos/search`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        word: searchEventName,
      }),
    });
    const orderData = await response.json();
    console.log({ orderData });
    if (orderData?.error) {
      throw new Error(`${orderData?.error}`);
    } else if (orderData?.eventos) {
      const select = document.getElementById('eventList');
      if (select != null) {
        removeOptions(select);
        for (let i = 0; i < orderData.eventos.length; i++) {
          let op = document.createElement('option');
          op.value = orderData.eventos[i].id;
          const eventName = orderData.eventos[i].name;
          const eventDate = orderData.eventos[i].formatted_date;
          const eventTime = orderData.eventos[i].formatted_time;
          op.innerHTML = `${eventName} ${eventDate} ${eventTime}`;
          op.setAttribute('data-name', eventName);
          select.appendChild(op);
        }
      }
    } else {

    }
  } catch (error) {
    console.error(error);
    resultMessage(
      `Disculpa, no se pudo realizar la busqueda...<br><br>${error}`,
    );
  }
  toggleSpinner();
}

async function searchEmail() {
  let search = document.getElementById('searchEmailName').value;
  toggleSpinner();
  try {
    const response = await fetch(`/api/correos/search`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        word: search,
      }),
    });
    const orderData = await response.json();
    console.log({ orderData });
    if (orderData?.error) {
      throw new Error(`${orderData?.error}`);
    } else if (orderData?.correos) {
      const select = document.getElementById('emailList');
      if (select != null) {
        removeOptions(select);
        for (let i = 0; i < orderData.correos.length; i++) {
          let op = document.createElement('option');
          op.value = orderData.correos[i].id;
          const email = orderData.correos[i].email;
          op.innerHTML = `${email}`;
          op.setAttribute('data-name', email);
          select.appendChild(op);
        }
      }
    } else {

    }
  } catch (error) {
    console.error(error);
    resultMessage(
      `Disculpa, no se pudo realizar la busqueda...<br><br>${error}`,
    );
  }
  toggleSpinner();
}

const debouncedEventSearchData = debounce(searchEvent, 1500);
const debouncedEmailSearchData = debounce(searchEmail, 1500);
var eventModal = null;
var emailModal = null;

document.addEventListener("DOMContentLoaded", () => {
  const searchEventName = document.getElementById('searchEventName');
  const searchEmailName = document.getElementById('searchEmailName');
  const buttonEvent = document.getElementById('eventSelection');
  const buttonEmail = document.getElementById('emailSelection');
  const buttonEventModal = document.getElementById('openEventModal');
  const buttonEmailModal = document.getElementById('openEmailModal');

  if (searchEventName != null) {
    searchEventName.addEventListener('keyup', inputKeyupEvent);
  }
  if (searchEmailName != null) {
    searchEmailName.addEventListener('keyup', inputKeyupEmail);
  }
  if (buttonEvent != null) {
    buttonEvent.addEventListener('click', selectEvent);
  }
  if (buttonEmail != null) {
    buttonEmail.addEventListener('click', selectEmail);
  }
  if (buttonEventModal != null) {
    buttonEventModal.addEventListener('click', openEventModal);
  }
  if (buttonEmailModal != null) {
    buttonEmailModal.addEventListener('click', openEventEmail);
  }

  eventModal = new bootstrap.Modal('#eventModal', {});
  emailModal = new bootstrap.Modal('#emailModal', {});
});
