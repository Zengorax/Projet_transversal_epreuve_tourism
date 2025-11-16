document.addEventListener('DOMContentLoaded', function () {
  var reserveBtn = document.getElementById('reserveBtn');
  var modalEl = document.getElementById('confirmReserveModal');
  var modalPriceEl = document.getElementById('modalPrice');
  var reserveAlert = document.getElementById('reserveAlert');
  var confirmBtn = document.getElementById('confirmReserveBtn');

  if (!reserveBtn || !modalEl || !modalPriceEl || !confirmBtn || !reserveAlert) {
    console.warn('reservation.js: missing DOM elements', {
      reserveBtn: !!reserveBtn,
      modalEl: !!modalEl,
      modalPriceEl: !!modalPriceEl,
      confirmBtn: !!confirmBtn,
      reserveAlert: !!reserveAlert
    });
    return;
  }
  var circuitId = reserveBtn.getAttribute('data-circuit-id');
  var isLoggedIn = reserveBtn.getAttribute('data-logged-in') === '1';
  var price = reserveBtn.getAttribute('data-price') || '—';

  modalEl.addEventListener('show.bs.modal', function () {
    reserveAlert.classList.add('d-none');
    reserveAlert.classList.remove('alert-success', 'alert-danger', 'alert-warning');

    modalPriceEl.textContent = price;

    if (!isLoggedIn) {
      reserveAlert.textContent = 'Vous devez être connecté pour réserver.';
      reserveAlert.classList.remove('d-none');
      reserveAlert.classList.add('alert-warning');
      confirmBtn.disabled = true;
    } else {
      confirmBtn.disabled = false;
    }
  });

  confirmBtn.addEventListener('click', function () {
    confirmBtn.disabled = true;
    reserveAlert.classList.add('d-none');

    fetch('/reservation_submit.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: circuitId })
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
      if (data && data.success) {
        reserveAlert.textContent = 'Réservation effectuée.';
        reserveAlert.classList.remove('d-none', 'alert-danger', 'alert-warning');
        reserveAlert.classList.add('alert-success');
        setTimeout(function () {
          var modalInstance = bootstrap.Modal.getInstance(modalEl);
          if (modalInstance) modalInstance.hide();
        }, 900);
      } else {
        reserveAlert.textContent = (data && data.message) ? data.message : 'Erreur lors de la réservation.';
        reserveAlert.classList.remove('d-none', 'alert-success', 'alert-warning');
        reserveAlert.classList.add('alert-danger');
        confirmBtn.disabled = false;
      }
    })
    .catch(function () {
      reserveAlert.textContent = 'Erreur réseau.';
      reserveAlert.classList.remove('d-none', 'alert-success', 'alert-warning');
      reserveAlert.classList.add('alert-danger');
      confirmBtn.disabled = false;
    });
  });
});
