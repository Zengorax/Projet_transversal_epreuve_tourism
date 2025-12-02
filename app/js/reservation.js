document.addEventListener('DOMContentLoaded', function () {
  const modalEl = document.getElementById('confirmReserveModal');
  if (!modalEl) return;

  const unitPriceSelectors = ['#modalPrice', '#prix-unitaire', '#prixUnitaire', '#modal-price'];
  const nbSelectors = ['#modalNbPersonne', '#nb-personne', '#nbPersonne', '#modal-nb-personne'];
  const totalSelectors = ['#modalTotalPrice', '#prix-total', '#prixTotal', '#modal-total-price'];

  function firstEl(selectors) {
    for (let s of selectors) {
      const el = modalEl.querySelector(s);
      if (el) return el;
    }
    return null;
  }

  const unitPriceEl = firstEl(unitPriceSelectors);
  const nbInput = firstEl(nbSelectors);
  const totalEl = firstEl(totalSelectors);
  const reserveAlert = modalEl.querySelector('#reserveAlert') || null;
  const confirmBtn = modalEl.querySelector('#confirmReserveBtn');

  if (!nbInput || !confirmBtn) return;

  let currentCircuitId = null;
  let currentUnitPrice = 0;

  modalEl.addEventListener('show.bs.modal', function (event) {
    const triggerBtn = event.relatedTarget;
    if (!triggerBtn) return;

    currentCircuitId = triggerBtn.getAttribute('data-circuit-id') || triggerBtn.getAttribute('data-id') || null;
    const priceStr = (triggerBtn.getAttribute('data-price') || triggerBtn.getAttribute('data-prix') || triggerBtn.dataset.price || '0').toString();
    currentUnitPrice = parseFloat(priceStr.replace(',', '.')) || 0;

    nbInput.value = 1;
    nbInput.setAttribute('min', '1');
    nbInput.setAttribute('max', '10');

    if (unitPriceEl) unitPriceEl.textContent = currentUnitPrice.toFixed(2);
    if (totalEl) totalEl.textContent = currentUnitPrice.toFixed(2);

    if (reserveAlert) {
      reserveAlert.classList.add('d-none');
      reserveAlert.classList.remove('alert-success', 'alert-danger', 'alert-warning');
    }

    confirmBtn.disabled = false;
  });

  nbInput.addEventListener('input', function () {
    let nb = parseInt(nbInput.value, 10);
    if (isNaN(nb) || nb < 1) nb = 1;
    if (nb > 10) {
      nb = 10;
      nbInput.value = '10';
    }
    if (totalEl) totalEl.textContent = (nb * currentUnitPrice).toFixed(2);
  });

  confirmBtn.addEventListener('click', function () {
    confirmBtn.disabled = true;

    let nb_personne = parseInt(nbInput.value, 10);
    if (isNaN(nb_personne) || nb_personne < 1) nb_personne = 1;
    if (nb_personne > 10) nb_personne = 10;

    if (!currentCircuitId) {
      if (reserveAlert) {
        reserveAlert.textContent = 'Erreur interne : ID du circuit manquant.';
        reserveAlert.classList.remove('d-none');
        reserveAlert.classList.add('alert-danger');
      }
      confirmBtn.disabled = false;
      return;
    }

    const payload = { id: parseInt(currentCircuitId, 10), nb_personne: nb_personne };

    fetch('reservation_submit.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
    .then(resp => {
      if (!resp.ok) throw new Error('Network response not ok: ' + resp.status);
      return resp.json();
    })
    .then(data => {
      if (data && data.success) {
        if (reserveAlert) {
          reserveAlert.textContent = data.message || 'Réservation effectuée.';
          reserveAlert.classList.remove('d-none', 'alert-danger', 'alert-warning');
          reserveAlert.classList.add('alert-success');
        } else {
          alert(data.message || 'Réservation effectuée.');
        }
        setTimeout(() => {
          const bsModal = bootstrap.Modal.getInstance(modalEl);
          if (bsModal) bsModal.hide();
        }, 800);
      } else {
        const msg = (data && data.message) ? data.message : 'Erreur lors de la réservation.';
        if (reserveAlert) {
          reserveAlert.textContent = msg;
          reserveAlert.classList.remove('d-none', 'alert-success', 'alert-warning');
          reserveAlert.classList.add('alert-danger');
        } else {
          alert(msg);
        }
        confirmBtn.disabled = false;
      }
    })
    .catch(() => {
      if (reserveAlert) {
        reserveAlert.textContent = 'Erreur réseau.';
        reserveAlert.classList.remove('d-none', 'alert-success', 'alert-warning');
        reserveAlert.classList.add('alert-danger');
      } else {
        alert('Erreur réseau.');
      }
      confirmBtn.disabled = false;
    });
  });
});
