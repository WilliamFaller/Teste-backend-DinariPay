<?php

error_reporting(0);

$mysql = mysqli_connect('localhost', 'root', '', 'dados');

if (!$mysql) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar ao banco de dados']);
} else {

    if (!isset($_GET['data'])) {
        echo json_encode(['success' => false, 'message' => 'Nao foi inserido a data para a busca']);
        return;
    }

    $validar = explode('-', $_GET['data']);
    if (!(isset($validar[0], $validar[1], $validar[2]))) {
        echo json_encode(['success' => false, 'message' => 'A data esta no formato incorreto']);
        return;
    }
    if (strlen($validar[0]) != 4) {
        echo json_encode(['success' => false, 'message' => 'A data esta no formato incorreto']);
        return;
    }
    if (strlen($validar[1]) != 2) {
        echo json_encode(['success' => false, 'message' => 'A data esta no formato incorreto']);
        return;
    }
    if (strlen($validar[2]) != 2) {
        echo json_encode(['success' => false, 'message' => 'A data esta no formato incorreto']);
        return;
    }

    $data = $_GET['data'];
    $sql = mysqli_query($mysql, "SELECT id FROM usuarios WHERE nascimento='" . $data . "';");

    $ids = [];

    while ($row = mysqli_fetch_assoc($sql)) {
        $ids[] = $row['id'];
    }

    if (empty($ids)) {
        echo json_encode(['success' => false, 'message' => 'Nao ha usuario cadastrado com essa data de nascimento']);
        return;
    }

    echo json_encode(['success' => true, 'ids' => $ids]);

}
