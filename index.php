<?php

session_start(); // Iniciar a sessão

ob_start(); // Limpar o buffer de saída

// Importar as classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Incluir o arquivo com a conexão com banco de dados
include_once "./conexao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="carrossel.css">
    <!-- <script src="index.js"></script> -->
    <title>Login</title>

</head>

<body>

    <!-- <h2>Login</h2> -->

    <?php
        // Exemplo criptografar a senha
        //echo password_hash(123456, PASSWORD_DEFAULT);

        // Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Acessar o IF quando o usuário clicar no botão acessar do formulário
    if (!empty($dados['SendLogin'])) {
        //var_dump($dados);

        // Recuperar os dados do usuário no banco de dados
        $query_usuario = "SELECT id, nome, usuario, senha_usuario 
                            FROM usuarios
                            WHERE usuario =:usuario
                            LIMIT 1";

        // Preparar a QUERY
        $result_usuario = $conn->prepare($query_usuario);

        // Substituir o link da query pelo valor que vem do formulário
        $result_usuario->bindParam(':usuario', $dados['usuario']);

        // Executar a QUERY
        $result_usuario->execute();

        // Acessar o IF quando encontrar usuário no banco de dados
        if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
            // Ler os registros retorando do banco de dados
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
            //var_dump($row_usuario);

            // Acessar o IF quando a senha é válida
            if (password_verify($dados['senha_usuario'], $row_usuario['senha_usuario'])) {
                // Salvar os dados do usuário na sessão
                $_SESSION['id'] = $row_usuario['id'];
                $_SESSION['usuario'] = $row_usuario['usuario'];

                // Recuperar a data atual
                $data = date('Y-m-d H:i:s');

                // Gerar número randômico entre 100000 e 999999
                $codigo_autenticacao = mt_rand(100000, 999999);
                //var_dump($codigo_autenticacao);

                // QUERY para salvar no banco de dados o código e a data gerada
                $query_up_usuario = "UPDATE usuarios SET
                                codigo_autenticacao =:codigo_autenticacao,
                                data_codigo_autenticacao =:data_codigo_autenticacao
                                WHERE id =:id
                                LIMIT 1";

                // Preparar a QUERY
                $result_up_usuario = $conn->prepare($query_up_usuario);

                // Substituir o link da QUERY pelo valores
                $result_up_usuario->bindParam(':codigo_autenticacao', $codigo_autenticacao);
                $result_up_usuario->bindParam(':data_codigo_autenticacao', $data);
                $result_up_usuario->bindParam(':id', $row_usuario['id']);

                // Executar a QUERY
                $result_up_usuario->execute();

                // Incluir o Composer
                require './lib/vendor/autoload.php';

                // Criar o objeto e instanciar a classe do PHPMailer
                $mail = new PHPMailer(true);

                // Verificar se envia o e-mail corretamente com try catch
                try {
                    // Imprimir os erro com debug
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  

                    // Permitir o envio do e-mail com caracteres especiais
                    $mail->CharSet = 'UTF-8';
                   
                    // Definir para usar SMTP
                    $mail->isSMTP();         

                    // Servidor de envio de e-mail
                    $mail->Host       = 'smtp.office365.com'; 

                    // Indicar que é necessário autenticar
                    $mail->SMTPAuth   = true;     

                    // Usuário/e-mail para enviar o e-mail                              
                    $mail->Username   = 'felipetrabalhop2@hotmail.com'; 

                    // Senha do e-mail utilizado para enviar e-mail                  
                    $mail->Password   = '@Lone81303930';      

                    // Ativar criptografia                         
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  

                    // Porta para enviar e-mail          
                    $mail->Port       = 587;

                    // E-mail do rementente
                    $mail->setFrom('felipetrabalhop2@hotmail.com', 'Felipe');

                    // E-mail de destino
                    $mail->addAddress($row_usuario['usuario'], $row_usuario['nome']);

                    // Definir formato de e-mail para HTML
                    $mail->isHTML(true);  
                    
                    // Título do e-mail
                    $mail->Subject = 'Aqui está o código de verificação de 6 dígitos que você solicitou';

                    // Conteúdo do e-mail em formato HTML
                    $mail->Body    = "Olá " . $row_usuario['nome'] . ", Autenticação multifator.<br><br>Seu código de verificação de 6 dígitos é $codigo_autenticacao<br><br>Esse código foi enviado para verificar seu login.<br><br>";

                    // Conteúdo do e-mail em formato texto
                    $mail->AltBody = "Olá " . $row_usuario['nome'] . ", Autenticação multifator.\n\nSeu código de verificação de 6 dígitos é $codigo_autenticacao\n\nEsse código foi enviado para verificar seu login.\n\n";

                    // Enviar e-mail
                    $mail->send();

                    // Redirecionar o usuário
                    header('Location: validar_codigo.php');

                } catch (Exception $e) { // Acessa o catch quando não é enviado e-mail corretamente
                    echo "E-mail não enviado com sucesso. Erro: {$mail->ErrorInfo}";
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não enviado com sucesso!</p>";
                }
            } else {
                $_SESSION['msg'] = "<p id='mensagem' style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p id='mensagem' style='color: #f00;'>Erro: Usuário ou senha inválida!</p>";
        }
    }

    // Imprimir a mensagem da sessão
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    ?>

  

<div class="carousel-container">
        <div class="carousel-slide">
        <img src="data:image/png;base64,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" alt="Image 1">
        <img src="data:image/jpeg;base64,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" alt="Image 2">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7tvDHoDnM3MfqfZhjS0rxBIw5ISH5thk56A&usqp=CAU" alt="Image 3">
        </div>
        <div class="carousel-prev">&#10094;</div>
        <div class="carousel-next">&#10095;</div>
    </div>
    <!-- Inicio do formulário de login -->
    <form  method="POST" action="">
    

    <h2>Login</h2>
        <label>Usuário: </label>
        <input type="text" name="usuario" placeholder="Digite o usuário"><br><br>
        
        <label>Senha: </label>
        <input type="password" name="senha_usuario" placeholder="Digite a senha"><br><br>

        <input type="submit" name="SendLogin" value="Acessar">
        <label id="cadastro">Ainda não tem conta? </label>
        <button type="button" onclick="window.location.href='cadastrar.php'">Cadastrar</button>

    </form><br>
    <!-- Fim do formulário de login -->

  
    <script src="carrossel.js"></script>
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

    <script src="carrossel.js"></script>

</body>


</html>