<?php
$hostname = "localhost";
$bancodedados = "textilgo";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

if($mysqli->connect_errno) {
    echo "falha na conexao: (". $mysqli->connect_errno .")" . $mysqli->connect_error;
}else{
    echo "Conectado ao Banco de dados";
}
?>