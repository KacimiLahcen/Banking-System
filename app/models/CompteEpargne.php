<?php
// require_once __DIR__ . '/Compte.php';

// class CompteEpargne extends Compte {

//     public function deposer(float $montant): void
//     {
//         $this->solde += $montant;
//     }

//     public function retirer(float $montant): void
//     {
//         if ($montant > $this->solde) {
//             throw new Exception("Ur money iz not enough");
//         }

//         $this->solde -= $montant;
//     }









class CompteEpargne extends Compte
{
    // dépôt
    public function deposer(float $montant): bool
    {
        try {
            self::$db->beginTransaction();

            $nouveauSolde = $this->solde + $montant;
            $this->update($this->id, ['solde' => $nouveauSolde]);

            $transaction = new Transaction();
            $transaction->enregistrer('depot', $montant, $this->id);

            self::$db->commit();
            return true;

        } catch (Exception $e) {
            self::$db->rollback();
            return false;
        }
    }

    // retrait
    public function retirer(float $montant): bool
    {
        if ($this->solde < $montant) {
            return false;
        }

        try {
            self::$db->beginTransaction();

            $nouveauSolde = $this->solde - $montant;
            $this->update($this->id, ['solde' => $nouveauSolde]);

            $transaction = new Transaction();
            $transaction->enregistrer('retrait', $montant, $this->id);

            self::$db->commit();
            return true;

        } catch (Exception $e) {
            self::$db->rollback();
            return false;
        }
    }
}




























// }

//polymorphisme PHP ; means same func but dif outputs
//méthode abstraite PHP ; the func that is oblig to write in the extends class 
//classe abstraite PHP ; just a base fo extends(Héritage) class 