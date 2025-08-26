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

        // Seleciona os elementos de link com ícone do WhatsApp
        const btnsWhatsapp = modalBody.querySelectorAll('.btn-whatsapp');

        btnsWhatsapp.forEach(btn => {
          btn.addEventListener('click', function (e) {
            e.preventDefault(); // impede que o link recarregue a página

            const telefone = btn.getAttribute('data-telefone').replace(/\D/g, '');
            const nome = btn.getAttribute('data-nome');

            const mensagem = encodeURIComponent(`Olá ${nome}, você tem uma reunião agendada no site de reuniões.`);

            window.open(`https://wa.me/55${telefone}?text=${mensagem}`, '_blank');
          });
        });
      })
      .catch(() => {
        modalBody.innerHTML = '<p>Erro ao carregar participantes.</p>';
      });
  });
});

document.getElementById('cpfAdicionar').addEventListener('blur', function () {
    const cpf = this.value;

    if (cpf.trim() === '') return;

    fetch('src/verificar_cpf.php?cpf=' + encodeURIComponent(cpf))
        .then(response => response.json())
        .then(data => {
            if (data.status === 'existe') {
                alert('Este CPF já está cadastrado!');
                document.getElementById('cpfAdicionar').value = '';
                document.getElementById('cpfAdicionar').focus();
            }
        })
        .catch(error => {
            console.error('Erro ao verificar CPF:', error);
        });
});