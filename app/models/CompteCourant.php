<?php
require_once __DIR__ . "/Compte.php";
require_once __DIR__ . "/Transaction.php";


class CompteCourant extends Compte
{
    private float $decouvertMax = -500;
    // protected string $table = "comptes";


    // depot
    public function deposer(float $montant): bool
    {
        try {
            static::$db->beginTransaction();

            $frais = 1;
            $nouveauSolde = $this->solde + ($montant - $frais);

            $this->update($this->id, ['solde' => $nouveauSolde]);
             $this->solde = $nouveauSolde;

            $transaction = new Transaction();
            $transaction->enregistrer('depot', $montant, $this->id);

            static::$db->commit();
            return true;

        } catch (Exception $e) {
            static::$db->rollback();
            return false;
        }
    }

    //  retrait
    public function retirer(float $montant): bool
    {
        if ($this->solde - $montant < $this->decouvertMax) {
           
            throw new Exception("Découvert max atteint");

        }

        try {
            static::$db->beginTransaction();

            $nouveauSolde = $this->solde - $montant;
            $this->update($this->id, ['solde' => $nouveauSolde]);
            $this->solde = $nouveauSolde;

            $transaction = new Transaction();
            $transaction->enregistrer('retrait', $montant, $this->id);

            static::$db->commit();
            return true;

        } catch (Exception $e) {
            static::$db->rollback();
            return false;
        }
    }
}





































// try {
//     $compte = new CompteCourant("CC-001", 100, 1);

//     echo "Numéro : " . $compte->getNumero() . "<br>";
//     echo "Solde initial : " . $compte->getSolde() . "<br>";

//     $compte->deposer(50);
//     echo "Après dépôt (50 - 1$ frais) : " . $compte->getSolde() . "<br>";

//     $compte->retirer(120);
//     echo "Après retrait 120 : " . $compte->getSolde() . "<br>";

//     $compte->retirer(600);
//     echo "Après retrait 600 : " . $compte->getSolde() . "<br>";

// } catch (Exception $message) {
//     echo "Erreur : " . $message->getMessage();
// }
// } catch (Exception ) {
//     echo "Erreur : tu dépassé le max de découvert";
// }