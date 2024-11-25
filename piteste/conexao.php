<?php
// Definindo os dados de conexão
$servidor = "localhost";  // Ou o IP do seu servidor de banco de dados
$usuario = "root";        // Usuário do MySQL
$senha = "";              // Senha do MySQL
$banco = "estudio_tatuagem";       // Nome do banco de dados

// Criando a conexão com o banco de dados
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verificando se a conexão foi bem-sucedida
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>
