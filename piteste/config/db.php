<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'estudio_tatuagem';

// Criando conexão
$conn = new mysqli($host, $user, $pass, $db_name);

// Verificando conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
