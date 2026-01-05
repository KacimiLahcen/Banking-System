<?php
require_once __DIR__ . "/BaseModel.php";

//abstract class means a base class for other classes that extends from it 
abstract class Compte extends BaseModel
{
    
    protected string $table = "comptes";
    
    protected int $id;
    protected string $numero;
    protected float $solde;
    protected int $client_id;


    public function __construct(string $numero, float $solde, int $client_id)
    {
    parent::__construct();
        $this->numero = $numero;
        $this->solde = $solde;
        $this->client_id = $client_id;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }
    public function getSolde(): float
    {
        return $this->solde;
    }
    public function getClientId(): int
    {
        return $this->client_id;
    }

    //Méthodes abstraites dans Compte : that means every class that extends class Compte ; needs to write this func

    abstract public function deposer(float $montant): bool;
    abstract public function retirer(float $montant): bool;
}
