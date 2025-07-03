document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modalEditarParticipante');

  if (!modal) return;

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const idReuniao = button.getAttribute('data-id');

    const modalBody = document.getElementById('modalEditarParticipanteBody');
    if (!modalBody) return;

    modalBody.innerHTML = 'Carregando participantes...';

    fetch(`src/carregar_participantes.php?id=${idReuniao}`)
      .then(response => response.text())
      .then(html => {
        modalBody.innerHTML = html;
      })
      .catch(() => {
        modalBody.innerHTML = '<p>Erro ao carregar participantes.</p>';
      });
  });
});
