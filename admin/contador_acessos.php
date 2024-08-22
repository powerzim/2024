<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "terra";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obtém a contagem de acessos
$sql = "SELECT COUNT(*) AS total_acessos FROM acessos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Total de acessos: " . $row['total_acessos'];
} else {
    echo "Nenhum acesso registrado.";
}

$conn->close();
?>
