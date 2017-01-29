<?php

require_once('config/config.php');

class Database
{
    public $conn;
     
    public function dbConnection()
	{
	    $this->conn = null;    

	    try
		{
            $this->conn = new PDO("mysql:host=" . DbConfig::HOST . ";dbname=" . DbConfig::DB_NAME, DbConfig::USERNAME, DbConfig::PASSWORD);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
            exit;
        }
         
        return $this->conn;
    }
}
