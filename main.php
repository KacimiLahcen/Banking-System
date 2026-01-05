<?php

require_once __DIR__ . "/app/models/Client.php";
require_once __DIR__ . "/app/models/CompteCourant.php";
require_once __DIR__ . "/app/models/CompteEpargne.php";
require_once __DIR__ . "/app/models/Transaction.php";

function menuPrincipal()
{
    echo "\n==============================\n";
    echo "🏦 SYSTÈME DE GESTION BANCAIRE\n";
    echo "==============================\n";
    echo "1️  Gestion des clients\n";
    echo "2️  Gestion des comptes\n";
    echo "3️  Dépôt / Retrait\n";
    echo "4️  Historique des transactions\n";
    echo "0️  Quitter\n";
    echo " ==> Votre choix : ";
}

while (true) {
    menuPrincipal();
    $choix = trim(fgets(STDIN));

    switch ($choix) {

        case "1":
            echo "\n Gestion des clients\n";
            echo "1 - Créer client\n";
            echo "2 - Afficher clients\n";
            echo " Choix : ";
            $c = trim(fgets(STDIN));

            if ($c == "1") {
                echo "Nom : ";
                $nom = trim(fgets(STDIN));

                echo "Prénom : ";
                $prenom = trim(fgets(STDIN));

                echo "Email : ";
                $email = trim(fgets(STDIN));

                $client = new Client($nom, $prenom, $email);
                $client->save([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email
                ]);

                echo " Client créé avec succès\n";
            }
            break;

        case "2":
            echo "\n💳 Gestion des comptes\n";
            echo "1 - Créer compte courant\n";
            echo "2 - Créer compte épargne\n";
            echo "👉 Choix : ";
            $c = trim(fgets(STDIN));

            echo "Client ID : ";
            $clientId = trim(fgets(STDIN));

            if ($c == "1") {
                $compte = new CompteCourant();
                $compte->save([
                    'numero' => uniqid("CC-"),
                    'solde' => 0,
                    'type' => 'courant',
                    'clients_id' => $clientId,
                    'decouvert_max' => -500
                ]);
            } else {
                $compte = new CompteEpargne();
                $compte->save([
                    'numero' => uniqid("CE-"),
                    'solde' => 0,
                    'type' => 'epargne',
                    'clients_id' => $clientId,
                    'decouvert_max' => 0
                ]);
            }

            echo " Compte créé\n";
            break;

        case "3":
            echo "\n Opérations bancaires\n";
            echo "1 - Dépôt\n";
            echo "2 - Retrait\n";
            echo " Choix : ";
            $op = trim(fgets(STDIN));

            echo "Compte ID : ";
            $compteId = trim(fgets(STDIN));

            echo "Montant : ";
            $montant = trim(fgets(STDIN));

            //  simplification pédagogique
            $compte = new CompteCourant(); // courant

            if ($op == "1") {
                $compte->deposer($montant);
                echo "✅ Dépôt effectué\n";
            } else {
                $compte->retirer($montant);
                echo "✅ Retrait effectué\n";
            }
            break;

        case "4":
            echo "\n Historique des transactions\n";
            echo "Compte ID : ";
            $id = trim(fgets(STDIN));

            $transaction = new Transaction();
            $transactions = $transaction->historiqueCompte($id);


            foreach ($transactions as $t) {
                echo "{$t['date']} | {$t['type']} | {$t['montant']}\n";
            }
            break;

        case "0":
            echo " Au revoir !\n";
            exit;

        default:
            echo " Choix invalide\n";
    }
}
