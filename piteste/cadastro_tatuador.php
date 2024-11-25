<?php
session_start();
include('conexao.php'); // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    
    // Verificar se o e-mail já está cadastrado
    $query_check_email = "SELECT * FROM tatuadores WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $query_check_email);

    // Verificar se o e-mail já existe na tabela 'tatuadores'
    if (mysqli_num_rows($result_check_email) > 0) {
        echo "Este e-mail já está cadastrado. Por favor, use outro e-mail.";
    } else {
        // Criptografar a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir os dados do tatuador na tabela tatuadores
        $query = "INSERT INTO tatuadores (nome, email, senha) VALUES ('$nome', '$email', '$senha_hash')";
        
        // Verificar se a inserção foi bem-sucedida
        if (mysqli_query($conn, $query)) {
            echo "Cadastro realizado com sucesso!";
            // Redirecionar para a página de login ou painel
            header("Location: login_tatuador.php");
            exit();
        } else {
            // Caso haja um erro ao inserir os dados
            echo "Erro ao cadastrar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Cadastro - Tatuador</title>
</head>
<body>

<header>
        <div class="studio-info">
            <img src="LOGO_XOGUN1.jpg" alt="Logo" class="logo"> <!-- Substitua pelo caminho da sua logo -->
            <h1><u>SHOGUN STUDIO</u></h1>
        </div>
</header>
<section class="paraforms">

<!-- Formulário de cadastro -->
<form class="form-cadastro" action="cadastro_tatuador.php" method="POST">

<h1 class="titulo-cadastro">Cadastro de Tatuador</h1>

    <label class="label-cadastro" for="nome">Nome:</label>
    <input class="input-cadastro" type="text" name="nome" id="nome" required>

    <label class="label-cadastro" for="email">E-mail:</label>
    <input class="input-cadastro" type="email" name="email" id="email" required>

    <label class="label-cadastro" for="senha">Senha:</label>
    <input class="input-cadastro" type="password" name="senha" id="senha" required>

    <button class="botao-cadastro" type="submit">Cadastrar</button>
</form>
</section>
</body>
</html>
