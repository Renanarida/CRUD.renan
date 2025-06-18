// Pega os dois modais
var modalParticipantes = document.getElementById('modalParticipantes');
var modalEditarParticipante = document.getElementById('modalEditarParticipante');

// Função comum para carregar participantes
function carregarParticipantes(modal, event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');

    // Preenche o campo hidden com o id da reunião
    var idReuniaoField = modal.querySelector('#id_reuniao');
    if (idReuniaoField) {
        idReuniaoField.value = id;
    }

    // Carrega participantes via AJAX (se tiver um body pra isso)
    var modalBody = modal.querySelector('#modalParticipantesBody');
    if (modalBody) {
        modalBody.innerHTML = 'Carregando...';

        fetch('./src/carregar_participantes.php?id=' + id)
            .then(response => response.text())
            .then(html => {
                modalBody.innerHTML = html;
            })
            .catch(error => {
                modalBody.innerHTML = '<p class="text-danger">Erro ao carregar participantes.</p>';
            });
    }
}

// Evento para o modal de visualizar participantes
if (modalParticipantes) {
    modalParticipantes.addEventListener('show.bs.modal', function(event) {
        carregarParticipantes(modalParticipantes, event);
    });
}

// Evento para o modal de editar participante
if (modalEditarParticipante) {
    modalEditarParticipante.addEventListener('show.bs.modal', function(event) {
        carregarParticipantes(modalEditarParticipante, event);
    });
}

// Máscara para telefone celular brasileiro
var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};

$(document).ready(function(){
    $('.sp_celphones').mask(SPMaskBehavior, spOptions);
});
