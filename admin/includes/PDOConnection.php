<?php
class PDOConnection {
   private $host = "localhost";
   private $user = "root";
   private $password = "";
   private $database = "ampabase";
   private $error_message;    
   private $statement;    
   
   public function __construct() {
      $dataSourceName = "mysql:host=" . $this->host . "; dbname=" . $this->database;
      $options = array(
         PDO::ATTR_PERSISTENT => true,        
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      try {
         $this->databaseHandler = new PDO($dataSourceName, $this->user, $this->password, $options);
         echo "Connected!";
      } catch (PDOException $error) {
         $this->error_message = $error->getMessage();
         echo $this->error_message;
      }
   }

   public function query($query) {
      $this->statement = $this->databaseHandler->prepare($query);
   }

   public function bind_value($param, $value) {
      $type = (gettype($value) === "string" ? PDO::PARAM_STR : PDO::PARAM_INT);
      $this->statement->bindValue($param, $value, $type);
   }

   public function execute() {
      return $this->statement->execute();
   }

   public function confirm_result() {
      return $this->databaseHandler->lastInsertId();
   }
   
   public function fetch_all() {
      $this->execute();
      return $this->statement->fetchAll(PDO::FETCH_ASSOC);
   }
   
   public function fetch_one() {
      $this->execute();
      return $this->statement->fetch(PDO::FETCH_ASSOC);
   }
   
}
?>