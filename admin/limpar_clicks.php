<?php
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

// Consulta SQL para excluir todas as informações de usuários
$sql = "DELETE FROM acessos";

// Executar a consulta SQL
if ($conn->query($sql) === TRUE) {
    // Se a exclusão for bem-sucedida, enviar uma resposta de sucesso
    echo "Todas os clicks foram limpos com sucesso!";
} else {
    // Se houver algum erro, enviar uma resposta de erro
    echo "Erro ao limpar todos os clicks: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
