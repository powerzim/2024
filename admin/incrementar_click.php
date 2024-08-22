<?php
session_start();

// Verifica se o administrador está logado
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    exit("Acesso negado");
}

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "terra";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Incrementa o contador de cliques
$sql = "UPDATE sessoes_ativas SET num_clicks = num_clicks + 1";
if ($conn->query($sql) === TRUE) {
    // Retorna o novo número de cliques
    $result = $conn->query("SELECT num_clicks FROM sessoes_ativas LIMIT 1");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row["num_clicks"];
    } else {
        echo "0";
    }
} else {
    echo "Erro ao atualizar o contador de cliques: " . $conn->error;
}

$conn->close();
?>
