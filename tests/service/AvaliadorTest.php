<?php

namespace Antonio\Leilao\Tests\Service;
use PHPUnit\Framework\TestCase;

use Antonio\Leilao\Model\Leilao;
use Antonio\Leilao\Model\Usuario;
use Antonio\Leilao\Model\Lance;
use Antonio\Leilao\Service\Avaliador;


class AvaliadorTest extends TestCase
{
    public function testAvaliadorDeveEncontrarMaiorValorEmOrdemDecrescente()
    {
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
        SELF::assertEquals($valorEsperado, $maiorValor);
    }


    public function testAvaliadorDeveEncontrarMaiorValorEmOrdemCrescente()
    {
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
        SELF::assertEquals($valorEsperado, $maiorValor);
    }


    public function testAvaliadorDeveEncontrarMenorValorEmOrdemCrescente()
    {
        // ARRANGE ou GIVEN
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');


        $leilao->recebeLances(new Lance($joao, 2000));
        $leilao->recebeLances(new Lance($maria, 2500));


        // ACT ou WHEN
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $menorValor = $leiloeiro->getMenorValor();
        $valorEsperado = 2000;

        // ASSERT ou THEN
        SELF::assertEquals($valorEsperado, $menorValor);
    }
}
