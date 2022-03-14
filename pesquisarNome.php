<?php

error_reporting(0);

$mysql = mysqli_connect('localhost', 'root', '', 'dados');

if (!$mysql) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar ao banco de dados']);
} else {

    if (!isset($_GET['nome'])) {
        echo json_encode(['success' => false, 'message' => 'Nao foi inserido o nome para a busca']);
        return;
    }
    if (!(preg_match('/^[a-z]+$/i', $_GET['nome']) > 0)) {
        echo json_encode(['success' => false, 'message' => 'O nome inserido nao é valido']);
        return;
    }

    $nome = strtolower($_GET['nome']);
    $nome = mysqli_real_escape_string($mysql, $nome);
    $sql = mysqli_query($mysql, "SELECT id FROM usuarios WHERE LOWER(nome)='" . $nome . "';");

    $ids = [];

    while ($row = mysqli_fetch_assoc($sql)) {
        $ids[] = $row['id'];
    }

    if (empty($ids)) {
        echo json_encode(['success' => false, 'message' => 'Nao ha usuario cadastrado com esse nome']);
        return;
    }

    echo json_encode(['success' => true, 'ids' => $ids]);
}
