<?php

namespace Antonio\Leilao\Tests\Service;

use PHPUnit\Framework\TestCase;

use Antonio\Leilao\Model\Leilao;
use Antonio\Leilao\Model\Usuario;
use Antonio\Leilao\Model\Lance;
use Antonio\Leilao\Service\Avaliador;


class AvaliadorTest extends TestCase
{
    private $leiloeiro;

    public function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarMaiorValor(Leilao $leilao)
    {
        // ACT ou WHEN
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();
        $valorEsperado = 2500;

        // ASSERT ou THEN
        SELF::assertEquals($valorEsperado, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarMenorValor(Leilao $leilao)
    {
        // ACT ou WHEN
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();
        $valorEsperado = 1700;

        // ASSERT ou THEN
        SELF::assertEquals($valorEsperado, $menorValor);
    }


    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveBuscarOsTresMaioresLances(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1700, $maiores[2]->getValor());
    }


    /* ------------------- DADOS -------------------- */

    public function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147 0km');

        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');

        $leilao->recebeLances(new Lance($ana, 1700));
        $leilao->recebeLances(new Lance($joao, 2000));
        $leilao->recebeLances(new Lance($maria, 2500));

        return [
            "ordem-crescente" => [$leilao]
        ];
    }

    public function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0km');

        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');

        $leilao->recebeLances(new Lance($maria, 2500));
        $leilao->recebeLances(new Lance($joao, 2000));
        $leilao->recebeLances(new Lance($ana, 1700));

        return [
            "ordem-decrescente" => [$leilao]
        ];
    }

    public function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Fiat 147 0km');

        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');

        $leilao->recebeLances(new Lance($ana, 1700));
        $leilao->recebeLances(new Lance($maria, 2500));
        $leilao->recebeLances(new Lance($joao, 2000));

        return [
            "ordem-aleatória" => [$leilao]
        ];
    }
}
