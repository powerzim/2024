<?php
session_start();

// Conectar ao banco de dados (mesmo código de conexão)

// Obter as informações em tempo real
$online_users = contarSessoesAtivas($conn);
$total_clicks = contarTotalCliques($conn);

// Retornar os dados em formato JSON
echo json_encode(array("online_users" => $online_users, "total_clicks" => $total_clicks));
?>
