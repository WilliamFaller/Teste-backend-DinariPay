<?php

include 'validarCPF.php';

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

    $numLinhas = mysqli_num_rows($sql);
    if ($numLinhas == 0) {
        echo json_encode(['success' => false, 'message' => 'O usuario nao existe']);
        return;
    }
    if (isset($_GET['nome'])) {
        if (!(preg_match('/^[a-z]+$/i', $_GET['nome']) > 0)) {
            echo json_encode(['success' => false, 'message' => 'O nome inserido nao é valido']);
            return;
        }
    }
    if (isset($_GET['data'])) {
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
    }
    if (isset($_GET['cpf'])) {
        if (!validarCPF($_GET['cpf'])) {
            echo json_encode(['success' => false, 'message' => 'O cpf inserido nao é valido']);
            return;
        }
        if (existeCPF((int) $_GET['cpf'])) {
            echo json_encode(['success' => false, 'message' => 'O cpf inserido ja esta cadastrado']);
            return;
        }
    }

    $dadosInseridos = 0;

    if (isset($_GET['nome'])) {
        $dadosInseridos++;
        $nome = $_GET['nome'];
        $nome = mysqli_real_escape_string($mysql, $nome);
        $sql = mysqli_query($mysql, "UPDATE usuarios SET nome='" . $nome . "' WHERE id=" . $id . ";");
    }
    if (isset($_GET['cpf'])) {
        $dadosInseridos++;
        $cpf = (int) $_GET['cpf'];
        $sql = mysqli_query($mysql, "UPDATE usuarios SET cpf='" . $cpf . "' WHERE id=" . $id . ";");
    }
    if (isset($_GET['data'])) {
        $dadosInseridos++;
        $data = $_GET['data'];
        $sql = mysqli_query($mysql, "UPDATE usuarios SET nascimento='" . $data . "' WHERE id=" . $id . ";");
    }
    if ($dadosInseridos == 0) {
        echo json_encode(['success' => false, 'message' => 'Nenhum cadastro foi alterado']);
        return;
    }

    echo json_encode(['success' => true, 'message' => 'O usuario foi alterado com sucesso']);
}
