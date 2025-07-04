// Barra de pesquisa
const searchInput = document.getElementById('searchInput');
const cardsContainer = document.getElementById('cardsContainer');

if (searchInput && cardsContainer) {
    const cards = cardsContainer.getElementsByClassName('card-item');

    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();

        for (let card of cards) {
            const assunto = card.querySelector('.card-title').textContent.toLowerCase();
            const local = card.querySelector('.card-text').textContent.toLowerCase();
            const dataHora = card.querySelector('.card-subtitle').textContent.toLowerCase();

            if (assunto.includes(filter) || local.includes(filter) || dataHora.includes(filter)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('modalParticipantes');
  if (!modal) return; // evita erro se modal não existir

  modal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;

    const idReuniao = button.getAttribute('data-id');
    const inputIdReuniao = document.getElementById('id_reuniao');
    if (inputIdReuniao) inputIdReuniao.value = idReuniao;

    ['id_participante', 'UpnomeP', 'UptelefoneP', 'UpemailP', 'UpsetorP'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });

    const label = document.getElementById('modalParticipantesLabel');
    if (label) label.textContent = 'Adicionar Participante';

    const botao = document.getElementById('UpParticipante');
    if (botao) botao.textContent = 'Adicionar Participante';
  });
});

// Modal de adicionar participante
// var modalAddParticipante = document.getElementById('modalAddParticipante');
// if (modalAddParticipante) {
//     modalAddParticipante.addEventListener('show.bs.modal', function(event) {
//         var button = event.relatedTarget;
//         var idReuniao = button.getAttribute('data-reuniao-id');
//         modalAddParticipante.querySelector('#addParticipanteReuniaoId').value = idReuniao;
//     });
// }

// Formulário de adicionar participante
// var formAddParticipante = document.getElementById('formAddParticipante');
// if (formAddParticipante) {
//     formAddParticipante.addEventListener('submit', function(e) {
//         e.preventDefault();

//         var form = e.target;
//         var formData = new FormData(form);

//         fetch('./src/adicionar_participante.php', {
//                 method: 'POST',
//                 body: formData
//             })
//             .then(resp => resp.text())
//             .then(result => {
//                 if (result.trim() === "ok") {
//                     var modal = bootstrap.Modal.getInstance(modalAddParticipante);
//                     modal.hide();

//                     var id = formData.get('id_reuniao');
//                     console.log("Reunião ID: " + id);
//                     fetch('./src/carregar_participantes.php?id=' + id)
//                         .then(res => res.text())
//                         .then(html => {
//                             document.getElementById('modalParticipantesBody').innerHTML = html;
//                         });
//                 } else {
//                     alert("Erro ao adicionar participante.");
//                 }
//             });
//     });
// }
