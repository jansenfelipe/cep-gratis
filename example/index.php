<?php

require_once '../vendor/autoload.php';

use JansenFelipe\CepGratis\CepGratis;

if (isset($_POST['cep'])) {
    $dados = CepGratis::search($_POST['cep']);

    var_dump($dados);
    die;
}
?>

<form method="POST">

    <input type="text" name="cep" placeholder="CEP" />
    <button type="submit">Consultar</button>

</form>