<?php
/**
 * Configuração do Banco de Dados
 * Arquivo centralizado para credenciais e conexão
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'jogadores');

// Criar conexão com tratamento de erro
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexão
if (!$con) {
    die("Falha na conexão com o banco: " . mysqli_connect_error());
}

// Definir charset UTF-8
mysqli_set_charset($con, "utf8mb4");

?>
