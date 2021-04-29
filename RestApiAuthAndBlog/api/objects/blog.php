<?php

    class Blog {
        private $conn;
        private $table_name = "blogs";

        public $id;
        public $header;
        public $text;
        public $date_pub;
        public $user_id;

        public function __construct($db) {
            $this->conn = $db;
        }


        function read() {
            $query = "
                SELECT header,text,date_publicate,u.login,b.user_id
                FROM ".$this->table_name.' b,users u'.
                " WHERE b.id = ".$this->id.
                " AND b.user_id = ANY(
                       SELECT u.id
                       FROM users u
                )";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;

        }

        function  create() {
            $this->header = htmlspecialchars(strip_tags(urldecode($this->header)));
            $this->text = htmlspecialchars(strip_tags(urldecode($this->text)));

            $query = "INSERT INTO ".$this->table_name."(`header`,`text`,`date_publicate`,`user_id`)
             VALUES ('$this->header','$this->text','$this->date_pub','$this->user_id')";
            $stmt = $this->conn->prepare($query);



            if($stmt->execute()) {
                return true;
            }
            return false;
        }

        function  check($id){
            $query = "
                SELECT id 
                FROM ".$this->table_name."
                WHERE id = '$id' 
            ";
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute()){
                if ($stmt->rowCount() <= 0) return false;
            } return  true;


        }

        function update() {

            if(empty($this->check($this->id)))return false;

            $this->header = htmlspecialchars(strip_tags(urldecode($this->header)));
            $this->text = htmlspecialchars(strip_tags(urldecode($this->text)));
            $this->date_pub = htmlspecialchars(strip_tags($this->date_pub));

            $query = "UPDATE ". $this->table_name.
                " SET 
            header = '$this->header',
            text = '$this->text',
            date_publicate = '$this->date_pub'
            
           WHERE id = '$this->id'
           ";

            $stmt = $this->conn->prepare($query);




            if ($stmt->execute()){
                return true;
            } return  false;
        }

        function delete() {
            $query = "
                DELETE FROM " . $this->table_name . " WHERE id = ' $this->id'";
            $stmt = $this->conn->prepare($query);
            if($stmt->execute()){
                return true;
            } return false;
        }
    }

?>