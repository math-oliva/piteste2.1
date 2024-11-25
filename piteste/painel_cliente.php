<?php
session_start();
include('conexao.php'); // Conexão com o banco de dados

// Verificar se o cliente está logado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header('Location: login_cliente.php'); // Se não estiver logado ou não for cliente, redireciona para o login
    exit();
}

// Buscar os dados do cliente logado
$id_cliente = $_SESSION['id_usuario'];
$query_cliente = "SELECT * FROM clientes WHERE id = '$id_cliente'";
$result_cliente = mysqli_query($conn, $query_cliente);
$cliente = mysqli_fetch_assoc($result_cliente);

// Buscar os agendamentos do cliente
$query_agendamentos = "SELECT * FROM agendamentos WHERE id_cliente = '$id_cliente' ORDER BY data_agendamento ASC";
$result_agendamentos = mysqli_query($conn, $query_agendamentos);

// Função para formatar a data
function formatarData($data) {
    return date('d/m/Y H:i', strtotime($data));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Painel do Cliente</title>
</head>
<body>

<h1>Painel do Cliente</h1>

<!-- Informações do Perfil -->
<h2>Informações do Perfil</h2>
<p><strong>Nome:</strong> <?php echo $cliente['nome']; ?></p>
<p><strong>E-mail:</strong> <?php echo $cliente['email']; ?></p>
<p><strong>Telefone:</strong> <?php echo $cliente['telefone']; ?></p>

<!-- Link para editar perfil -->
<p><a href="editar_perfil_cliente.php">Editar Perfil</a></p>

<!-- Seção de Agendamentos -->
<h2>Meus Agendamentos</h2>
<?php if (mysqli_num_rows($result_agendamentos) > 0): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Data e Hora</th>
                <th>Tatuador</th>
                <th>Especialidade</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($agendamento = mysqli_fetch_assoc($result_agendamentos)): ?>
                <tr>
                    <td><?php echo formatarData($agendamento['data_agendamento']); ?></td>
                    <td>
                        <?php
                        // Buscar nome do tatuador
                        $id_tatuador = $agendamento['id_tatuador'];
                        $query_tatuador = "SELECT nome FROM tatuadores WHERE id = '$id_tatuador'";
                        $result_tatuador = mysqli_query($conn, $query_tatuador);
                        $tatuador = mysqli_fetch_assoc($result_tatuador);
                        echo $tatuador['nome'];
                        ?>
                    </td>
                    <td><?php echo $agendamento['especialidades']; ?></td>
                    <td><?php echo $agendamento['status']; ?></td>
                    <td>
                        <?php if ($agendamento['status'] == 'pendente'): ?>
                            <a href="cancelar_agendamento.php?id=<?php echo $agendamento['id']; ?>">Cancelar</a>
                        <?php else: ?>
                            <?php echo "Ação concluída"; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Você ainda não tem agendamentos.</p>
<?php endif; ?>

<!-- Link para agendar uma nova sessão -->
<h3><a href="agendar.php">Agendar uma nova sessão de tatuagem</a></h3>

<!-- Link para sair -->
<p><a href="logout.php">Sair</a></p>

</body>
</html>
