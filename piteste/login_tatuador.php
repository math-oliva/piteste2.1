<?php
session_start();
include('conexao.php'); // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);

    // Verificar o tatuador no banco de dados
    $query = "SELECT * FROM tatuadores WHERE email = '$email'"; // Consulta para buscar o tatuador
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);

        // Verificar se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = 'tatuador';  // Definir tipo de usuário para sessão

            // Verificar se o tatuador marcou a opção "lembrar-me"
            if (isset($_POST['lembrar-me'])) {
                // Criar um cookie de "lembrar-me" por 30 dias
                setcookie('lembrar_tatuador', $usuario['id'], time() + (30 * 24 * 60 * 60), "/", "", false, true); // 30 dias, cookie seguro
            }

            // Redirecionar para o painel do tatuador ou outra página específica
            header("Location: painel_tatuador.php"); // A página do painel do tatuador
            exit();
        } else {
            // Senha incorreta
            $erro = "Senha incorreta!";
        }
    } else {
        // E-mail não encontrado
        $erro = "E-mail não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login - Tatuador</title>
</head>
<body>
<header>
        <div class="studio-info">
            <img src="LOGO_XOGUN1.jpg" alt="Logo" class="logo"> <!-- Substitua pelo caminho da sua logo -->
            <h1><u>SHOGUN STUDIO</u></h1>
        </div>
</header>
<?php
// Exibir mensagem de erro, se houver
if (isset($erro)) {
    echo "<p style='color: red;'>$erro</p>";
}
?>

<!-- Formulário de login -->
<section class="paraforms">

<form class="logtatuador"action="login_tatuador.php" method="POST">
<p class="ttatuador">Login - Tatuador</p>
    <label class="labmail"for="email">E-mail:</label>
    <input type="email" name="email" id="email" required>

    <label class="labsenha" for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>
    
    <label class="lablembrar" for="lembrar-me"> Lembrar-me  
    <input type="checkbox" name="lembrar-me" id="lembrar-me">
    </label>
    
    
    <button class="butao" type="submit">Entrar</button>

    <p class="futtatuador">Não tem conta? <a href="cadastro_tatuador.php">Cadastre-se aqui</a></p>


</form>
</section>
</body>
</html>
