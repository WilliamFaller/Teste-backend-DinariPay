<?php

error_reporting(0);

$mysql = mysqli_connect('localhost', 'root', '', 'dados');

if (!$mysql) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar ao banco de dados']);
} else {

    if (!isset($_GET['mes'])) {
        echo json_encode(['success' => false, 'message' => 'Nao foi inserido o mes para a busca dos aniversariantes']);
        return;
    }

    if ($_GET['mes'] < 1 || $_GET['mes'] > 12) {
        echo json_encode(['success' => false, 'message' => 'O mes inserido nao existe']);
        return;
    }

    $sql = mysqli_query($mysql, "SELECT * FROM usuarios;");

    $idsAniversariantes = [];

    $mesParaPesquisar = (int) $_GET['mes'];

    while ($row = mysqli_fetch_assoc($sql)) {
        $nascimento = explode('-', $row['nascimento']);
        $mes = (int) $nascimento[1];

        if ($mes == $mesParaPesquisar) {
            $idsAniversariantes[] = $row['id'];
        }
    }

    if (empty($idsAniversariantes)) {
        echo json_encode(['success' => false, 'message' => 'Nao ha nenhum aniversariante nesse mes']);
        return;
    }

    echo json_encode(['success' => true, 'ids' => $idsAniversariantes]);
}
