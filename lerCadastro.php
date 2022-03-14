<?php

error_reporting(0);

$mysql = mysqli_connect('localhost', 'root', '', 'dados');

if (!$mysql) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar ao banco de dados']);
} else {

    if (!isset($_GET['id'])) {
        echo json_encode(['success' => false, 'message' => 'Nao foi inserido o id para a busca']);
        return;
    }

    if (!is_numeric($_GET['id'])) {
        echo json_encode(['success' => false, 'message' => 'O id precisa ser numerico']);
        return;
    }

    $id = (int) $_GET['id'];
    $sql = mysqli_query($mysql, "SELECT * FROM usuarios WHERE id=" . $id . ";");

    $cpf = -1;
    $nome = '';
    $data = '0000-00-00';

    while ($row = mysqli_fetch_assoc($sql)) {
        $cpf = $row['cpf'];
        $nome = $row['nome'];
        $data = $row['nascimento'];
    }

    if ($cpf == -1 and $data == '0000-00-00' and $nome == '') {
        echo json_encode(['success' => false, 'message' => 'Nao ha usuario cadastrado com esse id']);
        return;
    }

    echo json_encode(['success' => true, 'cpf' => $cpf, 'nome' => $nome, 'nascimento' => $data]);
}
