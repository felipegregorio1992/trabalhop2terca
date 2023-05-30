// Obtém o elemento da mensagem
let mensagemElemento = document.getElementById('mensagem');

// Exibe a mensagem
mensagemElemento.style.display = 'block';

// Define o tempo em milissegundos para a mensagem desaparecer (por exemplo, 3000ms = 3 segundos)
let tempoDesaparecer = 3000;

// Aguarda o tempo especificado e esconde a mensagem
setTimeout(function() {
mensagemElemento.style.display = 'none';
}, tempoDesaparecer);