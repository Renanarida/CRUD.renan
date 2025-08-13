document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('modalAdicionarParticipante');
  if (modal) {
    modal.addEventListener('show.bs.modal', function (event) {
      // Pega o botão que abriu o modal
      const button = event.relatedTarget;
      // Pega o id da reunião do atributo data-id_reuniao do botao
      const idReuniao = button.getAttribute('data-id_reuniao');

      // Reseta o formulário
      const form = document.getElementById('formAdicionarParticipante');
      if (form) {
        form.reset();
      }

      // Preenche o campo hidden com o id da reunião
      const inputIdReuniao = document.getElementById('idReuniaoInput');
      if (inputIdReuniao) {
        inputIdReuniao.value = idReuniao || '';
      }
    });
  }
});
// Máscara de celular brasileiro
document.addEventListener('DOMContentLoaded', function() {
  const phoneInputs = document.querySelectorAll('.sp_celphones');

  function mascaraTelefone(event) {
    let input = event.target;
    let valor = input.value.replace(/\D/g, '');

    if (valor.length > 11) {
      valor = valor.slice(0, 11);
    }

    if (valor.length > 10) {
      // (00) 00000-0000
      valor = valor.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (valor.length > 5) {
      // (00) 0000-0000
      valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (valor.length > 2) {
      // (00) 0000
      valor = valor.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else {
      // (00
      valor = valor.replace(/^(\d*)/, '($1');
    }

    input.value = valor;
  }

  phoneInputs.forEach(input => {
    input.addEventListener('input', mascaraTelefone);
  });
});

// mascara de cpf
const inputCPF = document.getElementById('cpfAdicionar');
inputCPF.addEventListener('input', function(e) {
  let v = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número

  // Limita a 11 números
  if (v.length > 11) v = v.slice(0, 11);

  // Adiciona máscara do CPF
  v = v.replace(/(\d{3})(\d)/, '$1.$2');
  v = v.replace(/(\d{3})(\d)/, '$1.$2');
  v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

  e.target.value = v;
});