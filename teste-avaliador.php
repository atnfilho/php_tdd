<?php

use Antonio\Leilao\Model\Leilao;
use Antonio\Leilao\Model\Lance;
use Antonio\Leilao\Model\Usuario;
use Antonio\Leilao\Service\Avaliador;

require 'vendor/autoload.php';


// ARRANGE ou GIVEN
$leilao = new Leilao('Fiat 147 0km');

$maria = new Usuario('Maria');
$joao = new Usuario('João');


$leilao->recebeLances(new Lance($joao, 2000));
$leilao->recebeLances(new Lance($maria, 2500));


// ACT ou WHEN
$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

$valorEsperado = 2500;


// ASSERT ou THEN
if($valorEsperado == $maiorValor) {
    echo "TESTE OK";
} else {
    echo "TESTE FALHOU";
}

