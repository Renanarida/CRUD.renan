var modalEditar = document.getElementById('modalEditarReuniao');

if (modalEditar) {
    modalEditar.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;

        var id = button.getAttribute('data-reuniao-id');
        var data = button.getAttribute('data-reuniao-data');
        var hora = button.getAttribute('data-reuniao-hora');
        var local = button.getAttribute('data-reuniao-local');
        var assunto = button.getAttribute('data-reuniao-assunto');

        modalEditar.querySelector('#editId').value = id;
        modalEditar.querySelector('#editData').value = data;
        modalEditar.querySelector('#editHora').value = hora;
        modalEditar.querySelector('#editLocal').value = local;
        modalEditar.querySelector('#editAssunto').value = assunto;

        modalEditar.querySelector('#formEditarReuniao').action = './src/edit_reuniao.php';
    });
}
