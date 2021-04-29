<?php
    class User {
        private $conn;
        private $table_name = "users";


        public $id;
        public $login;
        public $password;

        public  function __construct($db){
            $this->conn = $db;
        }


        //read()
        function  read(){
            $query  = "SELECT id,login,password FROM ".$this->table_name;

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        function create(){

            $query = "INSERT INTO ".$this->table_name." (`login`,`password`) VALUES ('$this->login','$this->password')";
            $stmt = $this->conn->prepare($query);

            $this->login = htmlspecialchars(strip_tags($this->login));
            $this->password=htmlspecialchars(strip_tags($this->password));

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

    }

?>