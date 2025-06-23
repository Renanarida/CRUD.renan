document.addEventListener('DOMContentLoaded', function() {
    var modalEditar = document.getElementById('modalParticipantes');

    modalEditar.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;

        console.log('Editar Participante aberto', button.getAttribute('data-id'));

        var id = button.getAttribute('data-id');
        var nome = button.getAttribute('data-nome');
        var email = button.getAttribute('data-email');
        var telefone = button.getAttribute('data-telefone');
        var setor = button.getAttribute('data-setor');

        // Preenchendo o formulário do modal
        modalEditar.querySelector('#id_participante').value = id;
        modalEditar.querySelector('#UpnomeP').value = nome;
        modalEditar.querySelector('#UpemailP').value = email;
        modalEditar.querySelector('#UptelefoneP').value = telefone;
        modalEditar.querySelector('#UpsetorP').value = setor; 
        // modalEditar.querySelector('#UpParticipante').innerHTML = "Editar Participante";
        // modalEditar.querySelector('.modal-title').innerHTML = "Editar Participante";
    });
});