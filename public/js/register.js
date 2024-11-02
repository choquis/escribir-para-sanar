window.paypal
  .Buttons({
    async createOrder() {
      let eventOption = document.querySelector('input[name="eventId"]:checked');
      if (eventOption == null) {
        resultMessage(`Por favor selecciona un taller<br>`);
        return;
      }
      try {

        let eventId = eventOption.value;
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let phone = document.getElementById('phone').value;

        console.log({name, email, phone})

        const response = await fetch("/api/paypal/order", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            eventId,
            name,
            email,
            phone
          }),
        });

        console.log({ response });
        const orderData = await response.json();
        console.log({ orderData });

        // Error en nuestro servidor
        if (response.status >= 300) {
          const errorMessage = orderData?.message;
          throw new Error(errorMessage);
        }

        // Error en Paypal
        if (orderData.id) {
          return orderData.id;
        } else {
          const errorDetail = orderData?.details?.[0];
          const errorMessage = errorDetail
            ? `${errorDetail.issue} ${errorDetail.description} (${orderData.debug_id})`
            : JSON.stringify(orderData);
          throw new Error(errorMessage);
        }
      } catch (error) {
        console.error(error);
        resultMessage(`No se puede iniciar el proceso...<br><br>${error}`);
      }
    },
    async onApprove(data, actions) {
      console.log({ data });
      try {
        const response = await fetch(`/api/paypal/order/${data.orderID}/capture`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
        });
        toggleW8Message(true);
        const orderData = await response.json();
        // Three cases to handle:
        //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
        //   (2) Other non-recoverable errors -> Show a failure message
        //   (3) Successful transaction -> Show confirmation or thank you message
        const errorDetail = orderData?.details?.[0];
        if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
          // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
          // recoverable state, per https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
          return actions.restart();
        } else if (errorDetail) {
          // (2) Other non-recoverable errors -> Show a failure message
          throw new Error(`${errorDetail.description} (${orderData.debug_id})`);
        } else if (!orderData.purchase_units) {
          throw new Error(JSON.stringify(orderData));
        } else {
          // (3) Successful transaction -> Show confirmation or thank you message
          // Or go to another URL:  actions.redirect('thank_you.html');
          /*
          const transaction =
            orderData?.purchase_units?.[0]?.payments?.captures?.[0] ||
            orderData?.purchase_units?.[0]?.payments?.authorizations?.[0];
          resultMessage(
            `Compra completada ${transaction.status}: ${transaction.id}`,
          );
          */
          location.href = '/inscribir/completado';
        }
      } catch (error) {
        console.error(error);
        resultMessage(
          `Disculpa, no se pudo procesar el pago...<br><br>${error}`,
        );
      }
      toggleW8Message(false);
    },
  })
  .render("#paypal-button-container");

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

  var rad = document.registration.eventId;
  var prev = null;

  if (rad && rad instanceof RadioNodeList) {
    for (var i = 0; i < rad.length; i++) {
      rad[i].addEventListener('change', function (e) {
        (prev) ? prev.value : null;
        if (this !== prev) {
          prev = this;
        }
        toggleButtons(e.target.dataset.price);
      });
    }
  }
  else if (rad && rad instanceof HTMLElement) {
    rad.addEventListener('change', function (e) {
      (prev) ? prev.value : null;
      if (this !== prev) {
        prev = this;
      }
      toggleButtons(e.target.dataset.price);
    });
  }

  let eventOption = document.querySelector('input[name="eventId"]:checked');
  if (eventOption != null) {
    toggleButtons(eventOption.dataset.price);
  }
});

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

function toggleW8Message(show = true) {
  const paypalContainer = document.getElementById('paypal-button-container');
  const w8Container = document.getElementById('paypal-waiting-container');
  if (paypalContainer) paypalContainer.hidden = !show;
  if (w8Container) paypalContainer.hidden = show;
}

function checkNavbar() {
  lastKnownScrollPosition = window.scrollY;
  const nav = document.getElementById('navbar');
  const logo = document.getElementById('logo');
  nav.classList.add('opaque');
  logo.classList.add('black');
}