<?php

namespace Antonio\Leilao\Tests\Model;

use Antonio\Leilao\Model\Leilao;
use Antonio\Leilao\Model\Lance;
use Antonio\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase 
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $leilao = new Leilao("Variant");

        $ana = new Usuario("Ana");
        $leilao->recebeLances(new Lance($ana, 1000));
        $leilao->recebeLances(new Lance($ana, 1500));

        static::assertCount(1, $leilao->getLances());
        static::assertEquals(1000, $leilao->getLances()[0]->getValor());
    }

    public function testLeilaoNaoDeveAceitarMaisDeCincoLancesDoMesmoUsuario()
    {
        $leilao = new Leilao("Brasilia Amarela");

        $joao = new Usuario("João");
        $maria = new Usuario("Maria");

        $leilao->recebeLances(new Lance($joao, 1000));
        $leilao->recebeLances(new Lance($maria, 1500));
        $leilao->recebeLances(new Lance($joao, 2000));
        $leilao->recebeLances(new Lance($maria, 2500));
        $leilao->recebeLances(new Lance($joao, 3000));
        $leilao->recebeLances(new Lance($maria, 3500));
        $leilao->recebeLances(new Lance($joao, 4000));
        $leilao->recebeLances(new Lance($maria, 4500));
        $leilao->recebeLances(new Lance($joao, 5000));
        $leilao->recebeLances(new Lance($maria, 5500));

        $leilao->recebeLances(new Lance($joao, 6000));

        static::assertCount(10, $leilao->getLances());
        static::assertEquals(5500, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(int $qtdeLances, Leilao $leilao, array $valores)
    {
        static::assertCount($qtdeLances, $leilao->getLances());

        foreach($valores as $indice => $valorEsperado) {
            static::assertEquals($valorEsperado, $leilao->getLances()[$indice]->getValor());
        }

    }


    public function geraLances()
    {
        $joao = new Usuario("João");
        $maria = new Usuario("Maria");

        $leilaoComDoisLances = new Leilao("Fiat 147 0Km");

        $leilaoComDoisLances->recebeLances(new Lance($joao, 1000));
        $leilaoComDoisLances->recebeLances(new Lance($maria, 2000));

        $leilaoComUmLance = new Leilao("Fusca 1960 0Km");
        $leilaoComUmLance->recebeLances(new Lance($maria, 5000));

        return [
            "2-lances" => [2, $leilaoComDoisLances, [1000, 2000]],
            "1-lance" => [1, $leilaoComUmLance, [5000]]
        ];
    }
}