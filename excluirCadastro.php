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
    $sql = mysqli_query($mysql, "DELETE FROM usuarios WHERE id=" . $id . ";");

    $linhasAfetadas = mysqli_affected_rows($mysql);
    if ($linhasAfetadas == 0) {
        echo json_encode(['success' => false, 'message' => 'Nao ha usuario cadastrado com esse id']);
        return;
    }

    echo json_encode(['success' => true, 'message' => 'O usuario foi deletado com sucesso']);
}
