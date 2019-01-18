<?php
//required headers 
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
header("Acess-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object file 
include_once 'database.php';
include_once 'jwtGen.php';

class product{
	//database connection and table name
	private $conn;
	private $table_name="products_tb";
	
	//object properties
	public $id;
	public $name;
	public $description;
	public $price;
	public $category_id;
	public $category_name;
	public $created;
	
	//constructor with $db as database connection
	public function __construct($db){
		$this->conn=$db;
	}

//delete the product 
	function delete(){
		
		//delete query 
		$query="DELETE FROM ".$this->table_name." WHERE id=?";
		
		//prepare statement 
		$stmt=$this->conn->prepare($query);
		
		//sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));
		
		//bind id of record to delete 
		$stmt->bindParam(1, $this->id);
		
		//execute query
		if($stmt->execute()){
			return true;
		}
		return false;
		
	}
}

$heads=getallheaders();
//$Authorization=$heads[Authorization];
//$input=substr($Authorization,7);
//$checkAuth=Extractor($input);
//if(!$checkAuth){
	//http_response_code(400);
	//die("Authorization has been dienied for this request!");
//}
if($_SERVER['REQUEST_METHOD'] !='POST'){
	//set http response code
	http_response_code(400);
	//display error
	die('Invalid request method, Only POST request method alllowed');
}else{
//get database connection 
$database=new Database();
$db=$database->getConnection();

//prepare product object 
$product=new Product($db);

//get product id
$data=json_decode(file_get_contents("php://input"));

//set product id to be deleted
$product->id=$data->id;

//delete the product
if($product->delete()){
   $msg=array("Message "=>" Product was deleted successful.");
	echo (json_encode($msg));
	
}
//if unable to delete the product infor user 
else{
      http_response_code(400);
	echo '{';
		echo '"message":"unable to detele product."';
	echo '}';
}
}
?>
