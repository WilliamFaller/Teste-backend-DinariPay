<?php

include 'validarCPF.php';

error_reporting(0);

$mysql = mysqli_connect('localhost', 'root', '', 'dados');

if (!$mysql) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar ao banco de dados']);
} else {

    if (!isset($_GET['cpf'])) {
        echo json_encode(['success' => false, 'message' => 'Nao foi inserido o cpf para a busca']);
        return;
    }
    if (!validarCPF($_GET['cpf'])) {
        echo json_encode(['success' => false, 'message' => 'O cpf inserido nao é valido']);
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

    $cpf = (int) $_GET['cpf'];
    $sql = mysqli_query($mysql, "SELECT id FROM usuarios WHERE cpf=" . $cpf . ";");

    $id = -1;

    while ($row = mysqli_fetch_assoc($sql)) {
        $id = $row['id'];
    }

    if ($id == -1) {
        echo json_encode(['success' => false, 'message' => 'Nao ha usuario cadastrado com esse cpf']);
        return;
    }

    echo json_encode(['success' => true, 'id' => $id]);
}
