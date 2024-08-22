<?php
// Verificar se o ID do usuário foi recebido
if(isset($_GET['userId'])) {
    // Receber o ID do usuário
    $userId = $_GET['userId'];

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

    // Consulta SQL para excluir o usuário com base no ID
    $sql = "DELETE FROM usuarios WHERE id = $userId";

    // Executar a consulta SQL
    if ($conn->query($sql) === TRUE) {
        // Se a exclusão for bem-sucedida, enviar uma resposta de sucesso
        echo "Usuário excluído com sucesso!";
    } else {
        // Se houver algum erro, enviar uma resposta de erro
        echo "Erro ao excluir o usuário: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
} else {
    // Se o ID do usuário não foi recebido, enviar uma resposta de erro
    echo "ID do usuário não recebido!";
}
?>
