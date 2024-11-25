<?php
session_start();
include('conexao.php'); // Conexão com o banco de dados

// Verificar se o usuário está logado e se é um tatuador
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'tatuador') {
    header('Location: login_tatuador.php'); // Se não estiver logado ou não for tatuador, redireciona para o login
    exit();
}

// Buscar os dados do tatuador logado
$id_usuario = $_SESSION['id_usuario'];
$query_tatuador = "SELECT * FROM tatuadores WHERE id = '$id_usuario'";
$result_tatuador = mysqli_query($conn, $query_tatuador);
$tatuador = mysqli_fetch_assoc($result_tatuador);

// Buscar agendamentos do tatuador
$query_agendamentos = "SELECT * FROM agendamentos WHERE id_tatuador = '$id_usuario' ORDER BY data_agendamento ASC";
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
    <title>Painel do Tatuador</title>
</head>
<body>

<h1>Painel do Tatuador</h1>

<!-- Informações do Perfil -->
<h2>Informações do Perfil</h2>
<img src="uploads/<?php echo $tatuador['foto']; ?>" alt="Foto de Perfil" width="150" height="150">
<p><strong>Nome:</strong> <?php echo $tatuador['nome']; ?></p>
<p><strong>E-mail:</strong> <?php echo $tatuador['email']; ?></p>
<p><strong>Especialidades:</strong> <?php echo $tatuador['especialidades']; ?></p>

<!-- Link para editar perfil -->
<p><a href="editar_perfil_tatuador.php">Editar Perfil</a></p>

<!-- Seção de Agendamentos -->
<h2>Agendamentos</h2>
<?php if (mysqli_num_rows($result_agendamentos) > 0): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Data e Hora</th>
                <th>Cliente</th>
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
                        // Buscar nome do cliente
                        $id_cliente = $agendamento['id_cliente']; // ID do cliente no agendamento
                        $query_cliente = "SELECT nome FROM clientes WHERE id = '$id_cliente'"; // Consulta para buscar o nome do cliente
                        $result_cliente = mysqli_query($conn, $query_cliente);
                        $cliente = mysqli_fetch_assoc($result_cliente);
                        echo $cliente['nome']; // Exibe o nome do cliente
                        ?>
                    </td>
                    <td><?php echo $agendamento['status']; ?></td>
                    <td>
                        <?php if ($agendamento['status'] == 'pendente'): ?>
                            <a href="aceitar_agendamento.php?id=<?php echo $agendamento['id']; ?>">Aceitar</a> | 
                            <a href="recusar_agendamento.php?id=<?php echo $agendamento['id']; ?>">Recusar</a>
                        <?php else: ?>
                            <?php echo "Ação concluída"; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Você não tem agendamentos no momento.</p>
<?php endif; ?>

<!-- Link para sair -->
<p><a href="logout.php">Sair</a></p>

</body>
</html>
