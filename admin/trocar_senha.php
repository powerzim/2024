<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos necessários estão presentes no formulário
    if (isset($_POST["senha_atual"]) && isset($_POST["nova_senha"]) && isset($_POST["confirmar_senha"])) {
        // Aqui você pode adicionar validações adicionais, como verificar se a senha atual é válida, se a nova senha é segura, etc.
        
        // Obtém os valores dos campos do formulário
        $senha_atual = $_POST["senha_atual"];
        $nova_senha = $_POST["nova_senha"];
        $confirmar_senha = $_POST["confirmar_senha"];

        // Conectar ao banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "webmail";

        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Verificar a senha atual do administrador no banco de dados
        // Substitua 'id_do_usuario' pelo identificador real do administrador
        $id_do_usuario = 1; // Exemplo de ID do administrador
        $sql = "SELECT password FROM administradores WHERE id = '$id_do_usuario'";
        $result = $conn->query($sql);

        // Verifica se há resultados da consulta
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $senha_no_banco = $row["password"];
            // Compare a senha atual do formulário com a senha armazenada no banco de dados
            if ($senha_atual == $senha_no_banco) {
                // As senhas correspondem, agora você pode atualizar a senha no banco de dados
                $sql_update = "UPDATE administradores SET password = '$nova_senha' WHERE id = '$id_do_usuario'";
                if ($conn->query($sql_update) === TRUE) {
                    echo "Senha atualizada com sucesso!";
                    // Redirecionar para a página do administrador após 2 segundos
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'usuarios.php';
                            }, 2000);
                        </script>";
                } else {
                    echo "Erro ao atualizar a senha: " . $conn->error;
                }
            } else {
                echo "A senha atual está incorreta.";
            }
        } else {
            echo "Administrador não encontrado.";
        }
        
        // Fechar a conexão com o banco de dados
        $conn->close();

    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Troca de Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        
        .error {
            background-color: #dc3545;
            color: #fff;
        }
        
        .success {
            background-color: #28a745;
            color: #fff;
        }
        
        .btn-back {
            text-align: center;
            margin-top: 20px;
        }
        
        .btn-back a {
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        .btn-back a:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Troca de Senha</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="senha_atual">Senha Atual:</label>
            <input type="password" id="senha_atual" name="senha_atual">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha">
            <label for="confirmar_senha">Confirmar Nova Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha">
            <input type="submit" value="Trocar Senha">
        </form>
        <?php
        // Exibir mensagem de sucesso ou erro
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($conn)) {
                if ($conn->connect_error) {
                    echo '<div class="message error">' . $conn->connect_error . '</div>';
                } else {
                    echo '<div class="message success">Senha atualizada com sucesso!</div>';
                }
            }
        }
        ?>
        <div class="btn-back">
            <a href="usuarios.php">Voltar para a Página do Administrador</a>
        </div>
    </div>
</body>
</html>
