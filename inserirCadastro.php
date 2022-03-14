<?php

include 'validarCPF.php';

error_reporting(0);

$mysql = mysqli_connect('localhost', 'root', '', 'dados');

if (!$mysql) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar ao banco de dados']);
} else {

    if (!isset($_GET['nome'], $_GET['cpf'], $_GET['data'])) {
        echo json_encode(['success' => false, 'message' => 'Ha dados faltando para o cadastro']);
        return;
    }

    if (!validarCPF($_GET['cpf'])) {
        echo json_encode(['success' => false, 'message' => 'O cpf inserido nao é valido']);
        return;
    }

    if (!(preg_match('/^[a-z]+$/i', $_GET['nome']) > 0)) {
        echo json_encode(['success' => false, 'message' => 'O nome inserido nao é valido']);
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

    if(existeCPF((int) $_GET['cpf'])){
        echo json_encode(['success' => false, 'message' => 'O cpf inserido ja esta cadastrado']);
        return;
    }

    $cpf = (int) $_GET['cpf'];
    $data = $_GET['data'];
    $nome = $_GET['nome'];
    $nome = mysqli_real_escape_string($mysql, $nome);
    $sql = mysqli_query($mysql, "INSERT INTO usuarios (cpf, nome, nascimento) VALUES (".$cpf.", '".$nome."', '".$data."');");

    $linhasAfetadas = mysqli_affected_rows($mysql);
    if ($linhasAfetadas == 0) {
        echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao realizar o cadastro']);
        return;
    }

    echo json_encode(['success' => true, 'message' => 'O usuario foi cadastrado com sucesso']);
}
