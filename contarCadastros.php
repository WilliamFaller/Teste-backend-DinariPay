<?php

error_reporting(0);

$mysql = mysqli_connect('localhost', 'root', '', 'dados');

if (!$mysql) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar ao banco de dados']);
} else {
    $sql = mysqli_query($mysql, "SELECT * FROM usuarios;");
    $numLinhas = mysqli_num_rows($sql);
    echo json_encode(['success' => true, 'result' => $numLinhas]);
}
