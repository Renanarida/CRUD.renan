document.addEventListener('DOMContentLoaded', function () {
  document.addEventListener('click', function (event) {
    if (event.target.classList.contains('btn-editar-participante')) {
      const button = event.target;

      // Fecha modal de lista se estiver aberto
      const modalLista = bootstrap.Modal.getInstance(document.getElementById('modalEditarParticipante'));
      if (modalLista) modalLista.hide();

      // Preenche o formulário
      document.getElementById('editarId').value = button.getAttribute('data-id');
      document.getElementById('editarNome').value = button.getAttribute('data-nome');
      document.getElementById('editarEmail').value = button.getAttribute('data-email');
      document.getElementById('editarTelefone').value = button.getAttribute('data-telefone');
      document.getElementById('editarSetor').value = button.getAttribute('data-setor');
      document.getElementById('editarCpf').value = button.getAttribute('data-cpf'); // ✅ Adicione isto aqui!

      // Aguarda o fechamento do primeiro modal
      setTimeout(() => {
        const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarParticipanteIndividual'));
        modalEditar.show();
      }, 400);
    }
  });
});

document.getElementById('editarCpf').addEventListener('blur', function () {
    const cpf = this.value;
    const id = document.getElementById('editarId').value;

    if (cpf.trim() === '') return;

    fetch(`src/verificar_cpf.php?cpf=${encodeURIComponent(cpf)}&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'existe') {
                alert('Este CPF já está em uso por outro participante.');
                document.getElementById('editarCpf').value = '';
                document.getElementById('editarCpf').focus();
            }
        })
        .catch(error => {
            console.error('Erro ao verificar CPF:', error);
        });
});