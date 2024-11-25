<?php
session_start();
include('conexao.php'); // Conexão com o banco de dados

// Verificar se o usuário está logado e se é um tatuador
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'tatuador') {
    header('Location: login_tatuador.php'); // Se não estiver logado ou não for tatuador, redireciona para o login
    exit();
}

// Verificar se o ID do agendamento foi passado pela URL
if (isset($_GET['id'])) {
    $id_agendamento = $_GET['id'];

    // Atualizar o status do agendamento para 'recusado'
    $query = "UPDATE agendamentos SET status = 'recusado' WHERE id = '$id_agendamento' AND id_tatuador = '" . $_SESSION['id_usuario'] . "'";
    if (mysqli_query($conn, $query)) {
        // Redireciona de volta para o painel do tatuador
        header('Location: painel_tatuador.php');
        exit();
    } else {
        echo "Erro ao recusar o agendamento.";
    }
} else {
    echo "ID do agendamento não fornecido.";
}
?>
