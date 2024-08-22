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

// Consulta SQL para recuperar todas as informações dos usuários
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Verificar se há resultados
if ($result->num_rows > 0) {
    // Nome do arquivo
    $filename = "informacoes_usuarios.txt";

    // Abrir o arquivo para escrita
    $file = fopen($filename, "w");

    // Escrever o cabeçalho
    fwrite($file, "Você solicitou a Lista de Credenciais Terra\n\n");

    // Escrever os dados de cada usuário no arquivo
    while ($row = $result->fetch_assoc()) {
        fwrite($file, $row["email"] . ":" . $row["senha"] . "\n");
    }

    // Fechar o arquivo
    fclose($file);

    // Enviar o arquivo para download
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: text/plain");
    header("Content-Length: " . filesize($filename));
    readfile($filename);
    // Excluir o arquivo após o download
    unlink($filename);
} else {
    echo "Nenhum usuário encontrado.";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
