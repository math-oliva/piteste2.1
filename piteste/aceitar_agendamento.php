<?php
session_start();
include('conexao.php'); // Conexão com o banco de dados

// Verificar se o usuário está logado e se é um tatuador
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'tatuador') {
    header('Location: login_tatuador.php'); // Se não estiver logado ou não for tatuador, redireciona para o login
    exit();
}

// Verifica se o ID do agendamento foi passado via GET
if (isset($_GET['id'])) {
    $id_agendamento = $_GET['id'];
    $id_usuario = $_SESSION['id_usuario'];

    // Atualiza o status do agendamento para 'ACEITO'
    $query = "UPDATE agendamentos SET status = 'ACEITO' WHERE id = '$id_agendamento' AND id_tatuador = '$id_usuario'";

    // Executa a consulta
    if (mysqli_query($conn, $query)) {
        // Redireciona de volta para o painel do tatuador
        header('Location: painel_tatuador.php');
        exit();
    } else {
        echo "Erro ao aceitar o agendamento: " . mysqli_error($conn);
    }
} else {
    echo "ID do agendamento não fornecido.";
}
?>
