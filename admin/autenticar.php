<?php
session_start();

// Verifica se os dados foram submetidos através do método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configurações do banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "terra";

    // Cria uma conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtém os dados enviados pelo formulário de login
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para verificar as credenciais do administrador
    $sql = "SELECT * FROM administradores WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // Verifica se o resultado da consulta contém pelo menos uma linha
    if ($result->num_rows > 0) {
        // As credenciais estão corretas, redireciona para a página de informações do usuário
        $_SESSION["admin"] = true;
        header("Location: usuarios.php");
    } else {
        // As credenciais estão incorretas, exibe uma mensagem de erro
        $_SESSION["login_error"] = "Usuário ou senha incorretos.";
        header("Location: login_admin.php");
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    // Se o formulário não foi submetido via POST, redireciona de volta para a página de login
    header("Location: login_admin.php");
}
?>
