<?php
session_start();
include('conexao.php'); // Inclua sua conexão com o banco de dados

// Destruir a sessão
session_unset();
session_destroy();

// Remover o cookie "lembrar_cliente" se existir
if (isset($_COOKIE['lembrar_cliente'])) {
    setcookie('lembrar_cliente', '', time() - 3600, "/"); // Expira o cookie
}

// Redirecionar para a página de login
header("Location: login_cliente.php");
exit();
?>
