<?php 
/// Only for database collection
trait DB {
private $DB_HOST="mysql-server";  
private $DB_NAME="docker_database"; 
private $DB_USER="root"; 
private $DB_PASSWORD="12345"; 
private $connection = null;
public function __construct(){

}

private function CONNECT(){
  try{
        if ($this->connection === null) {
            $this->connection = new PDO("mysql:host=".$this->DB_HOST.";dbname=".$this->DB_NAME,$this->DB_USER,$this->DB_PASSWORD);
            $this->connection->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
            $this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
            $this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        return $this->connection;
    }catch(\PDOException $error){ 
        throw new \Exception($error->getMessage());
    }catch(\Exception $error){
        throw new \Exception($error->getMessage());
    }

}

private function disconnect()
{
    $this->connection = null;
}
private function dbconfig()
{
    $config = new stdClass();
    $config->DB_HOST = $this->DB_HOST;
    $config->DB_NAME = $this->DB_NAME;
    $config->DB_USER = $this->DB_USER;
    $config->DB_PASSWORD = $this->DB_PASSWORD;
    return $config;
}

public function __destruct(){
    $this->connection = null;
}

}
?>
