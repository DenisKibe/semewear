<?php
//required headers
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;");
header("Access-Control-Allow-Methods:GET");

//include database 
include_once 'database.php';

class product{
	//database connection and table name
	private $conn;
	private $table_name="products_tb";
	
	//object properties
	
	
	//constructor with $db as database connection
	public function __construct($db){
		$this->conn=$db;
	}
	
	//read products
	function read(){
		//select all query
		$query="SELECT 
					*
				FROM
					 ".$this->table_name;
					
		//prepare query statemant
		$stmt=$this->conn->Prepare($query);
		
		//execute query
		$stmt->execute();
		
		
		return $stmt;	
	}
}
if($_SERVER['REQUEST_METHOD'] != 'GET'){
	//set http code
	http_response_code(400);
	//display error
	die('Invalid request method, Only GET request method allowed');
}else{
//instantiate database and product
$database=new Database();
$db=$database->getConnection();

//initialize object
$product=new product($db);

//query products
$stmt=$product->read();
$num=$stmt->rowCount();

//check if more than o records found
if($num>0){
	//products array
	$products_arr=array();
	
	//retrieve our table contents
	//fetch()
	while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row
		//this will make $row['name']to
		//just $name only
		extract($row);

		$product_item=array(
			"id"=>$id,
			"name"=>$pName,
			"description"=>html_entity_decode($pDescription),
			"price"=>$pPrice,
			"category_id"=>$pCategoryId,
			"category_name"=>$pCategoryName,
			"image_url"=>html_entity_decode($imageUrl)
		);
		array_push($products_arr,$product_item);
	}
	echo json_encode($products_arr);
	
}
else{
	echo json_encode(
		array("message"=>"No products found.")
	);
}
}
?>
