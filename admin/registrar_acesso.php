<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "terra";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$sql = "INSERT INTO acessos (data_acesso) VALUES (CURRENT_TIMESTAMP)";
if ($conn->query($sql) === TRUE) {
    echo "Acesso registrado com sucesso.";
} else {
    echo "Erro ao registrar acesso: " . $conn->error;
}

$conn->close();
?>
