<?php
require_once __DIR__ . "/BaseModel.php";
class Transaction extends BaseModel
{
    protected string $table = 'transactions';

    public function __construct()
    {
        parent::__construct();
    }

    // save a new transaction ;
    public function enregistrer(
        string $type,
        float $montant,
        int $compteId
    ): bool {
        return $this->save([
            'type' => $type,
            'montant' => $montant,
            'date' => date('Y-m-d H:i:s'),
            'compte_id' => $compteId
        ]);
    }

    //get transaction date to a specifc account
    public function historiqueCompte(int $compteId): array
    {
        $stmt = self::$db->prepare(
            "SELECT * FROM transactions 
             WHERE compte_id = ? 
             ORDER BY date DESC"
        );
        $stmt->execute([$compteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
