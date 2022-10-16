<?php

namespace Antonio\Leilao\Model;

class Leilao
{
    private array $lances = [];
    private string $descricao;
    private bool $finalizado;
    
    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->finalizado = false;
    }

    public function recebeLances(Lance $lance)
    {
        if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            throw new \DomainException('Usuário não pode propor dois lances seguidos');
        }

        $usuario = $lance->getUsuario();
        $totalLancesUsuario = $this->quantidadeDeLancesPorUsuario($usuario);

        if ($totalLancesUsuario >= 5) {
            throw new \DomainException('Usuário não pode propor mais de 5 lances por leilão');
        }

        $this->lances[] = $lance;
    }

    public function getLances(): array
    {
        return $this->lances;
    }

    public function estaFinalizado()
    {
        return $this->finalizado;
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

    public function finaliza()
    {
        $this->finalizado = true;
    }
}
