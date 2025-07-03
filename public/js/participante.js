const modal = document.getElementById('modalEditarParticipante');

modal.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const idReuniao = button.getAttribute('data-id');
  const modalBody = document.getElementById('modalParticipantesBody');

  modalBody.innerHTML = 'Carregando...';

  fetch(`../src/participante.php?id_reuniao=${idReuniao}`)
    .then(response => response.text())
    .then(data => {
      modalBody.innerHTML = data;
    })
    .catch(error => {
      modalBody.innerHTML = 'Erro ao carregar participantes.';
      console.error('Erro:', error);
    });
});