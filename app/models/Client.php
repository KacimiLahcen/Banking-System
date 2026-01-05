<?php
    
require_once __DIR__ . "/BaseModel.php";

    class Client extends BaseModel
    {
        
        protected string $table = "clients"; //???
        
        // the encapsulation part : to protect proprieties,
        private string $nom;
        private string $prenom;
        private string $email;

        //constructor: obligate right data;
        public function __construct(string $nom, string $prenom, string $email)
        {

            $this->setNom($nom);
            $this->setprenom($prenom);

            // $this->email = $email
            $this->setEmail($email); //setEmail insside constructor to respect encapsulation principle, so we validate it first and avoid storing invalide values 
        }




        // public function save()
        // {
        //     $db = Database::instance();

        //     print_r($db);
        // }
        // public function show()
        // {
        //     $db = Database::instance();
        //     print_r($db);
        // }
        // public function update()
        // {
        //    $db = Database::instance();
        //     print_r($db);
        // }
        // public function delete()
        // {
        //     $db = Database::instance();
        //     print_r($db);
        // }





        //GETTERS 
        public function getNom(): string
        {
            return $this->nom;
        }

        public function getPrenom(): string
        {
            return $this->prenom;
        }
        public function getEmail(): string
        {
            return $this->email;
        }

        //setters

        public function setNom(string $nom): void
        {
            $this->nom = $nom;
        }
        public function setPrenom(string $prenom): void
        {
            $this->prenom = $prenom;
        }

        public function setEmail(string $email): void
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                throw new Exception("invalide email");
            }
            $this->email = $email;
        }
    }



    // $client = new Client("kacimi", "lahcen", "kacimi@gmail.com");

    // $client->save();
    // $client->show();
    // $client->update();
    // $client->delete();

// $client->setNom("badr");
// echo $client->getNom() . " <br>" . $client->getPrenom() . "<br>" . $client->getEmail();

// echo  $client->setNom("badr");