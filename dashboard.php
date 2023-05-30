<?php

session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Acessar o IF quando o usuário não estão logado e redireciona para página de login
if((!isset($_SESSION['id'])) and (!isset($_SESSION['usuario'])) and (!isset($_SESSION['codigo_autenticacao']))){
    $_SESSION['msg'] = "<p id='mensagem' style='color: #f00;'>Erro: Necessário realizar o login para acessar a página!</p>";

    // Redirecionar o usuário
    header("Location: index.php");

    // Pausar o processamento
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="video.css">
    <title>Dashboard</title>
</head>

<body>
     

        <a class="sair" href="sair.php">Sair</a>
        <h2>Bem-vindo <?php echo $_SESSION['nome']; ?></h2>
        
        


    <div class="video-grid">
    <div class="video">
        <div class="video-info">
            <span>3 Técnicas Que Eu Uso Para Aprender a Programar Qualquer Coisa</span>
        </div>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/ZtMzB5CoekE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        
        <div class="video-description">
            <p>Descrição do Vídeo 1</p>
        </div>
    </div>
    <div class="video">
        <div class="video-info">
            <span>Inteligência Artificial jogando Flappy Bird!!</span>
        </div>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/vavXvu_SMeM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        
        <div class="video-description">
            <p>Descrição do Vídeo 1</p>
        </div>
    </div>
    <div class="video">
        <div class="video-info">
            <span>TUDO SOBRE PHP EM 2023!</span>
        </div>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/5_CPIFc0vUU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        
        <div class="video-description">
            <p>Descrição do Vídeo 1</p>
        </div>
    </div>
    
    <div class="video">
        <div class="video-info">
            <span>Como ESTUDAR PROGRAMAÇÃO: Engenheiro de Computação</span>
        </div>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/bMLbf10uC0Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>        
        <div class="video-description">
            <p>Descrição do Vídeo 1</p>
        </div>
    </div>
    <div class="video">
        <div class="video-info">
            <span>Curso Python #01 - Seja um Programador</span>
        </div>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/S9uPNppGsGo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>        
        <div class="video-description">
            <p>Descrição do Vídeo 1</p>
        </div>
    </div>
        <div class="video">
            <div class="video-info">
                <span>6 Sites gratuitos para Praticar PROGRAMAÇÃO: Confira!</span>
            </div>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/1wYGwhQoRQE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            
            <div class="video-description">
                <p>Descrição do Vídeo 1</p>
            </div>
        </div>
    </div>

    <!-- Repita os blocos "div.video" para adicionar mais vídeos -->
  </div>

    <script>
        let mensagemElemento = document.getElementById('mensagem');
        let tempoPiscar = 500;
        let tempoDesaparecer = 4000;

        mensagemElemento.style.display = 'block';
        mensagemElemento.style.marginBottom = '-38px';

        let intervaloPiscar = setInterval(function() {
        mensagemElemento.style.display = mensagemElemento.style.display === 'none' ? 'block' : 'none';
        }, tempoPiscar);

        setTimeout(function() {
        clearInterval(intervaloPiscar);
        mensagemElemento.style.display = 'none';
        }, tempoDesaparecer);
    </script>

</body>

</html>