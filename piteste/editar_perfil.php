<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login_cliente.php");
    exit();
}

$id_cliente = $_SESSION['id_usuario'];  // ID do cliente logado
$query = "SELECT * FROM clientes WHERE id = '$id_cliente'";
$result = mysqli_query($conn, $query);
$cliente = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualiza os dados do cliente
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    
    // Verifica se foi enviada uma nova foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto'];
        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $novo_nome = "foto_" . $id_cliente . "." . $ext;
        $caminho_foto = "uploads/" . $novo_nome;
        
        // Move a foto para a pasta uploads
        move_uploaded_file($foto['tmp_name'], $caminho_foto);

        // Atualiza a foto no banco de dados
        $query_foto = ", foto = '$novo_nome' ";
    }

    // Atualiza os dados no banco de dados
    $query_update = "UPDATE clientes SET nome = '$nome', email = '$email', telefone = '$telefone' $query_foto WHERE id = '$id_cliente'";
    if (mysqli_query($conn, $query_update)) {
        echo "Perfil atualizado com sucesso!";
        header("Location: perfil_cliente.php"); // Redireciona para o perfil após a atualização
    } else {
        echo "Erro ao atualizar perfil.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Editar Perfil</title>
</head>
<body>

<h1>Editar Perfil</h1>

<form action="editar_perfil.php" method="POST" enctype="multipart/form-data">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?php echo $cliente['nome']; ?>" required>

    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" value="<?php echo $cliente['email']; ?>" required>

    <label for="telefone">Telefone:</label>
    <input type="text" name="telefone" id="telefone" value="<?php echo $cliente['telefone']; ?>" required>

    <label for="foto">Foto de Perfil:</label>
    <input type="file" name="foto" id="foto">

    <button type="submit">Atualizar Perfil</button>
</form>

</body>
</html>
