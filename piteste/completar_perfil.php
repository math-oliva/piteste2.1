<?php
// Iniciar a sessão para verificar se o usuário está logado
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login_cliente.php"); // Redirecionar para a página de login, caso não esteja logado
    exit();
}

// Conectar ao banco de dados
include('config/db.php');

// Buscar as informações do usuário no banco de dados
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM clientes WHERE id = '$id_usuario'";
$result = mysqli_query($conn, $query);
$usuario = mysqli_fetch_assoc($result);

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $estilos_preferidos = mysqli_real_escape_string($conn, $_POST['estilos_preferidos']);
    $tatuador_preferido = mysqli_real_escape_string($conn, $_POST['tatuador_preferido']);
    
    // Processar a foto de perfil
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // Definir o diretório de upload
        $pasta_upload = 'uploads/';
        $nome_arquivo = $_FILES['foto']['name'];
        $caminho_arquivo = $pasta_upload . $nome_arquivo;
        
        // Mover a foto para a pasta de uploads
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_arquivo)) {
            // Atualizar a foto no banco de dados
            $query = "UPDATE usuarios SET foto = '$caminho_arquivo', estilos_preferidos = '$estilos_preferidos', tatuador_preferido = '$tatuador_preferido', perfil_completo = 1 WHERE id = '$id_usuario'";
            mysqli_query($conn, $query);
            echo "Perfil atualizado com sucesso!";
        } else {
            echo "Erro ao fazer upload da foto!";
        }
    } else {
        // Atualizar o perfil sem a foto de perfil
        $query = "UPDATE clientes SET estilos_preferidos = '$estilos_preferidos', tatuador_preferido = '$tatuador_preferido', perfil_completo = 1 WHERE id = '$id_usuario'";
        mysqli_query($conn, $query);
        echo "Perfil atualizado com sucesso!";
    }
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Completar Perfil</h2>
        
        <!-- Exibir a foto de perfil atual -->
        <img src="<?php echo $usuario['foto']; ?>" alt="Foto de Perfil" width="150" height="150">
        
        <form action="completar_perfil.php" method="POST" enctype="multipart/form-data">
            <label for="foto">Alterar Foto de Perfil:</label>
            <input type="file" name="foto" id="foto">
            
            <label for="estilos_preferidos">Estilos de Tatuagem Preferidos:</label>
            <textarea name="estilos_preferidos" id="estilos_preferidos" rows="4" required><?php echo $usuario['estilos_preferidos']; ?></textarea>
            
            <label for="tatuador_preferido">Tatuador Preferido:</label>
            <input type="text" name="tatuador_preferido" id="tatuador_preferido" value="<?php echo $usuario['tatuador_preferido']; ?>" required>
            
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
