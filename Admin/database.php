<?php
class Database{
	private $host="localhost";
	private $db_name="semewear_db";
	private $username="semewear_root";
	private $password="#Wanyugik18";
	public $conn;
	//the database connection
	public function getConnection(){
		$this->conn=null;
		
		try{
			$this->conn=new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
			$this->conn->exec("set names utf8");
		}catch(PDOException $exception){
			echo "Connection error:".$exception->getMessage();
		}
		return $this->conn;
	}
}
?>
