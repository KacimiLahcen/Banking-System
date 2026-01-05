

<?php
    // class Database {
 
    //     private $db ;
    //     private static $instance = null ;

    //     public function __construct(){

    //         $host = 'localhost';
    //         $dbname = 'qodex';
    //         $user = 'root';
    //         $pass = '';

    //         try {
    //             $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    //             $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //             $this->db  = $DBH ;
           
               
    //         }
    //         catch(PDOException $e) {

    //             echo 'ERROR: ' . $e->getMessage();
    //         }

    //     } 

    //     public static function instance(){
    //         if(is_null(static::$instance)){
    //             static::$instance = new Database();
    //         }

    //         return static::$instance ;
    //     }
    //     public function connction(){
    //         return $this->db;
    //     }

    // } 


class database{
    private static $instance = null;
    private PDO $conn;

    private function __construct(){
        $this->conn = new PDO("mysql:host=localhost;dbname=banking-System;charset=utf8","root","");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public static function getInstance(){
        if (self::$instance === null){
            self::$instance = new database();
        }
        return self::$instance;

    }


    public function getConnection():PDO {
        return $this->conn;
    }

   
}

?>