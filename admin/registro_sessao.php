<?php
session_start();

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

// Capturar informações da sessão
$session_id = session_id();
$pagina_atual = 'index.html';
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$last_activity = date('Y-m-d H:i:s');

// Verificar se a sessão já existe
$sql = "SELECT * FROM sessoes_ativas WHERE session_id = '$session_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Atualizar a sessão existente e incrementar o contador de cliques
    $sql = "UPDATE sessoes_ativas SET pagina_atual = '$pagina_atual', ip = '$ip', user_agent = '$user_agent', last_activity = '$last_activity', num_clicks = num_clicks + 1 WHERE session_id = '$session_id'";
} else {
    // Inserir uma nova sessão e definir o contador de cliques como 1
    $sql = "INSERT INTO sessoes_ativas (session_id, pagina_atual, ip, user_agent, last_activity, num_clicks) VALUES ('$session_id', '$pagina_atual', '$ip', '$user_agent', '$last_activity', 1)";
}

if ($conn->query($sql) === TRUE) {
    echo "Sessão registrada com sucesso.";
} else {
    echo "Erro ao registrar sessão: " . $conn->error;
}

$conn->close();
?>
