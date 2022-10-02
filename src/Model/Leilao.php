<?php

namespace Antonio\Leilao\Model;

class Leilao 
{
    private array $lances; 
    private string $descricao; 
    
    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;   
    }

    public function recebeLances(Lance $lance)  
    {
        $this->lances[] = $lance;
    }

    public function getLances(): array
    {
        return $this->lances;
    }
}