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

      // Aguarda o fechamento do primeiro modal
      setTimeout(() => {
        const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarParticipanteIndividual'));
        modalEditar.show();
      }, 400);
    }
  });
});
