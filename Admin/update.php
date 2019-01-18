<?php
//required headers
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
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
	public $categoryId;
	public $categoryName;
	public $created;
	
	//constructor with $db as database connection
	public function __construct($db){
		$this->conn=$db;
	}
	

//update the product 
	function update(){
		//update query
		$query="UPDATE 
					".$this->table_name." 
				SET 
					pName=:name, 
					pPrice=:price, 
					pDescription=:description, 
					pCategoryId=:category_id,
					pCategoryName=:category_name,
					date_created=:created 
				WHERE 
					id=:id";
					
		//prepare query statement
		$stmt=$this->conn->prepare($query);
		
		//sanitize 
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->description=htmlspecialchars(strip_tags($this->description));
		$this->categoryId=htmlspecialchars(strip_tags($this->categoryId));
		$this->categoryName=htmlspecialchars(strip_tags($this->categoryName));
		$this->id=htmlspecialchars(strip_tags($this->id));
		$this->created=htmlspecialchars(strip_tags($this->created));
		
		//bind new values 
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':category_id', $this->categoryId);
		$stmt->bindParam(':category_name', $this->categoryName);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':created',$this->created);
		
		//execute the query
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
	die('Invalid request method, only POST request methods allowed');
}else{
//get database connection 
$database=new Database();
$db=$database->getConnection();

//prepare product object
$product=new Product($db);

//get id of product to be edited 
$data=json_decode(file_get_contents("php://input"));
$product_category_id=['0768gelHNF40irN'=>'women\'s fashion','1719ddpKAV03mmA'=>'Bags','2246pkvWRF10weS'=>'Shoes','6718hmj0ZT60xyU'=>'Hoods','9193tdbNLC48reT'=>'Men\'s fashion'];
$categoryId=array_search($data->category_name,$product_category_id);
//set product property values
$product->id=$data->id;
$product->name=$data->name;
$product->price=$data->price;
$product->description=$data->description;
$product->categoryName=$data->category_name;
$product->categoryId=$categoryId;
$product->created=date('Y-m-d H:m:s');

//update the product 
if($product->update()){
	echo '{';
		echo '"message":"Product was updated."';
	echo '}';
}
//if unable to update the product, infor the user
else{
	//set http error code
	http_response_code(400);
	echo '{';
		echo '"message":"Unable to update product."';
	echo '}';
}
}
?>
