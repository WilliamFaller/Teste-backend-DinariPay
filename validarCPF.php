<?php

function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);
    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

}

function existeCPF($cpf){
    $mysql = mysqli_connect('localhost', 'root', '', 'dados');

    if (!$mysql) {
        return true;
    } else {
        $sql = mysqli_query($mysql, "SELECT * FROM usuarios WHERE cpf=".$cpf.";");
        $numLinhas = mysqli_num_rows($sql);
        if($numLinhas == 0) return false;
        return true; 

    }
}
