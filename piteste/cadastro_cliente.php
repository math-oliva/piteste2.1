<?php
session_start();
require_once 'config/db.php';

// Função para gerar nome único para a foto
function gerarNomeUnico($extensao) {
    return uniqid() . '.' . $extensao;
}

// Processa o cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    // Processando upload de foto
    $foto = NULL;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $extensoes_validas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($extensao), $extensoes_validas)) {
            $nomeFoto = gerarNomeUnico($extensao);
            $caminhoFoto = 'uploads/' . $nomeFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoFoto);
            $foto = $caminhoFoto;
        } else {
            $erro = "Apenas arquivos de imagem são permitidos (jpg, jpeg, png, gif).";
        }
    }

    // Criptografando a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserindo os dados no banco
    if (!isset($erro)) {
        $stmt = $conn->prepare("INSERT INTO clientes (nome, email, senha, telefone, data_nascimento, foto, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, 'cliente')");
        $stmt->bind_param("ssssss", $nome, $email, $senha_hash, $telefone, $data_nascimento, $foto);

        if ($stmt->execute()) {
            $_SESSION['sucesso'] = "Cadastro realizado com sucesso! Faça login.";
            header("Location: login_cliente.php");
            exit();
        } else {
            $erro = "Erro ao realizar o cadastro. Tente novamente.";
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
    <title>Cadastro - Cliente</title>
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
<form method="POST" enctype="multipart/form-data" class="form-cadastro">

    <h1 class="titulo-cadastro">Cadastro de Cliente</h1>

    <label for="nome" class="label-nome">Nome:</label>
    <input type="text" name="nome" id="nome" required class="input-nome">

    <label for="email" class="label-email">E-mail:</label>
    <input type="email" name="email" id="email" required class="input-email">

    <label for="senha" class="label-senha">Senha:</label>
    <input type="password" name="senha" id="senha" required class="input-senha">

    <label for="telefone" class="label-telefone">Telefone:</label>
    <input type="text" name="telefone" id="telefone" class="input-telefone">

    <label for="data_nascimento" class="label-data-nascimento">Data de Nascimento:</label>
    <input type="date" name="data_nascimento" id="data_nascimento" required class="input-data-nascimento">

    <label for="foto" class="label-foto">Foto de Perfil:</label>
    <input type="file" name="foto" id="foto" class="input-foto">

    <button type="submit" class="botao-cadastro">Cadastrar</button>

</form>

</section>
</body>
</html>