<?php

namespace Antonio\Leilao\Model;

class Leilao
{
    private array $lances = [];
    private string $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
    }

    public function recebeLances(Lance $lance)
    {
        if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            return;
        }

        $usuario = $lance->getUsuario();
        $totalLancesUsuario = $this->quantidadeDeLancesPorUsuario($usuario);

        if ($totalLancesUsuario >= 5) {
            return;
        }

        $this->lances[] = $lance;
    }

    public function getLances(): array
    {
        return $this->lances;
    }

    private function ehDoUltimoUsuario($lance): bool
    {
        $ultimoLance = $this->lances[array_key_last($this->lances)];
        return $lance->getUsuario() === $ultimoLance->getUsuario();
    }

    private function quantidadeDeLancesPorUsuario($usuario): int
    {
        $totalLancesUsuario = array_reduce(
            $this->lances,
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUsuario() === $usuario) {
                    return ++$totalAcumulado;
                }
                return $totalAcumulado;
            },
            0
        );

        return $totalLancesUsuario;
    }
}
