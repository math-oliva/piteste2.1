<?php
session_start();
require_once('config/db.php'); // Conectar ao banco de dados

// Verifica se o tatuador está logado
if (!isset($_SESSION['id_tatuador'])) {
    header("Location: login_tatuador.php");
    exit();
}

// Obtém o ID do tatuador logado
$id_tatuador = $_SESSION['id_tatuador'];

// Busca as informações do tatuador no banco de dados
$query = "SELECT * FROM tatuadores WHERE id = $id_tatuador";
$result = mysqli_query($conn, $query);

// Verifica se a consulta retornou algum resultado
if (mysqli_num_rows($result) == 0) {
    die("Tatuador não encontrado.");
}

$tatuador = mysqli_fetch_assoc($result);

// Verifica se a chave 'bio' existe no array e define um valor padrão caso não exista
$bio = isset($tatuador['bio']) ? $tatuador['bio'] : '';

// Busca as especialidades do tatuador
$query_especialidades = "SELECT especialidade FROM especialidades_tatuador WHERE id_tatuador = $id_tatuador";
$result_especialidades = mysqli_query($conn, $query_especialidades);
$especialidades = [];
while ($row = mysqli_fetch_assoc($result_especialidades)) {
    $especialidades[] = $row['especialidade'];
}

// Busca todas as especialidades disponíveis no sistema
$query_todas_especialidades = "SELECT * FROM especialidades";
$result_todas_especialidades = mysqli_query($conn, $query_todas_especialidades);
$opcoes_especialidades = [];
while ($row = mysqli_fetch_assoc($result_todas_especialidades)) {
    $opcoes_especialidades[] = $row['nome'];
}

// Se o formulário for enviado, atualiza os dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $bio = $_POST['bio']; // Recebe o campo 'bio'
    $foto = $_FILES['foto']['name'];
    
    // Se houver upload de foto, salva
    if ($foto) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    } else {
        $foto = $tatuador['foto']; // Mantém a foto atual se nenhuma nova for carregada
    }

    // Atualiza as informações do tatuador no banco de dados
    $update_query = "UPDATE tatuadores SET nome = '$nome', email = '$email', bio = '$bio', foto = '$foto' WHERE id = $id_tatuador";
    if (mysqli_query($conn, $update_query)) {
        // Atualiza especialidades
        $update_especialidades = "DELETE FROM especialidades_tatuador WHERE id_tatuador = $id_tatuador";
        mysqli_query($conn, $update_especialidades);

        if (!empty($_POST['especialidades'])) {
            foreach ($_POST['especialidades'] as $especialidade) {
                $insert_especialidade = "INSERT INTO especialidades_tatuador (id_tatuador, especialidade) VALUES ($id_tatuador, '$especialidade')";
                mysqli_query($conn, $insert_especialidade);
            }
        }

        header("Location: painel_tatuador.php"); // Redireciona para o perfil após atualização
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Editar Perfil Tatuador</title>
</head>
<body>

<h2>Editar Perfil</h2>

<form action="editar_perfil_tatuador.php" method="POST" enctype="multipart/form-data">
    <div>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($tatuador['nome']); ?>" required>
    </div>
    
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($tatuador['email']); ?>" required>
    </div>

    <div>
        <label for="bio">Bio:</label>
        <textarea name="bio" id="bio" required><?php echo htmlspecialchars($bio); ?></textarea>
    </div>

    <div>
        <label for="foto">Foto de Perfil:</label>
        <input type="file" name="foto" id="foto">
    </div>

    <div>
        <label for="especialidades">Especialidades:</label>
        <select name="especialidades[]" id="especialidades" multiple>
            <?php
            foreach ($opcoes_especialidades as $especialidade) {
                // Verifica se a especialidade já está selecionada
                $selected = in_array($especialidade, $especialidades) ? 'selected' : '';
                echo "<option value='$especialidade' $selected>$especialidade</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>
