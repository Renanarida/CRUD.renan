 const inputCPF = document.getElementById('inputCPF');
  inputCPF.addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g, '');
    v = v.replace(/^(\d{3})(\d)/, '$1.$2');
    v = v.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
    v = v.replace(/\.(\d{3})(\d)/, '.$1-$2');
    e.target.value = v;
  });
  
  // Exemplo simples para capturar o submit
  document.getElementById('formCPF').addEventListener('submit', function(e) {
    e.preventDefault();
    const cpf = inputCPF.value;
    alert('CPF enviado: ' + cpf);
    // Aqui você pode fazer um fetch/ajax para enviar o CPF para o servidor
    // Ou fechar o modal, etc.
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCPF'));
    modal.hide();
  });


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

function toggleSidebar() {
                    const sidebar = document.getElementById("mySidebar");
                    const body = document.body;
                    if (sidebar.style.width === "250px") {
                        sidebar.style.width = "0";
                        body.classList.remove("sidebar-open");
                    } else {
                        sidebar.style.width = "250px";
                        body.classList.add("sidebar-open");
                    }
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