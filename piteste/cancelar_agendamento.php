<?php
session_start();
include('conexao.php'); // Conexão com o banco de dados

// Verificar se o cliente está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header('Location: login_cliente.php'); // Se não estiver logado ou não for cliente, redireciona para o login
    exit();
}

// Verificar se o ID do agendamento foi passado pela URL
if (isset($_GET['id'])) {
    $id_agendamento = $_GET['id'];

    // Atualizar o status do agendamento para 'cancelado'
    $query = "UPDATE agendamentos SET status = 'cancelado' WHERE id = '$id_agendamento' AND id_cliente = '" . $_SESSION['id_usuario'] . "'";
    if (mysqli_query($conn, $query)) {
        // Redireciona de volta para o painel do cliente
        header('Location: painel_cliente.php');
        exit();
    } else {
        echo "Erro ao cancelar o agendamento.";
    }
} else {
    echo "ID do agendamento não fornecido.";
}
?>
