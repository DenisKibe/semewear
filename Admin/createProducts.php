
<?php
header( "refresh:5;url=http://semewear.co.ke/Admin/createProduct.html" );
$image_url="";
include_once 'database.php';
include_once 'jwtGen.php';
include_once 'idgen.php';
class product{
	//database connection and table name
	private $conn;
	private $table_name="products_tb";
	
	//object properties
	public $id;
	public $productUrl;
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

	//create products
	function create(){
		//generate an id for the product
		$byte=genId();
		$productID=$byte; 
		
		//query to insert record
		$query="INSERT INTO 
					".$this->table_name." SET id=:productid, imageUrl=:productUrl, pName=:name, pPrice=:price, pDescription=:description, 
					pCategoryId=:category_id, pCategoryName=:category_name, date_created=:created";
					
		//prepare query
		$stmt=$this->conn->prepare($query);
		
		//sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->description=htmlspecialchars(strip_tags($this->description));
		$this->category_id=htmlspecialchars(strip_tags($this->categoryId));
		$this->category_name=htmlspecialchars(strip_tags($this->categoryName));
		$this->created=htmlspecialchars(strip_tags($this->created));
		
		//bind values
		$stmt->bindParam(":productid",$productID);
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":productUrl",$this->productUrl);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":category_id", $this->category_id);
		$stmt->bindParam(":category_name", $this->category_name);
		$stmt->bindParam(":created", $this->created);
		
		//execute query 
		if($stmt->execute()){
			return true;
		}
		return false;
	}
}
if(isset($_POST['SubmitD']) && $_SERVER['REQUEST_METHOD']=='POST'){
	
	$Authorization=$_POST['Verify'];
	$checkAuth=Extractor($Authorization);
	//if(! $checkAuth){
		//http_response_code(400);
		//die("Authorization has been dienied for this request!");
	//}
	//else{
		
		$fileType=$_FILES["imageName"]["type"];
		$typee=substr($fileType,6);
		$filename=genId().'.'.$typee;
		
		

	if($fileType=="image/jpg"|| $fileType=="image/png" || $fileType=="image/jpeg" && $_FILES["imageName"]["size"]>0)
		{
			move_uploaded_file($_FILES["imageName"]["tmp_name"],"uploads/$filename");
			$image_url="uploads/".$filename;
		 
		}else{
			echo ('invalid format: upload a jpg, png or jpeg format');
		}
		
	$product_category_id=['0768gelHNF40irN'=>'women\'s fashion','1719ddpKAV03mmA'=>'Bags','2246pkvWRF10weS'=>'Shoes','6718hmj0ZT60xyU'=>'Hoods','9193tdbNLC48reT'=>'Men\'s fashion'];


$database =new Database();
$db=$database->getConnection();



$product=new Product($db);

//search for product id in an array

$categoryId=array_search($_POST['pCatergory'],$product_category_id);
//set product property values
$product->productUrl=$image_url;
$product->name=$_POST['pName'];
$product->price=$_POST['pPrice'];
$product->description=$_POST['pDescrition'];
$product->categoryId=$categoryId;
$product->categoryName=$_POST['pCatergory'];
$product->created=date('Y-m-d H:i:s');

//Create the product
if($product->create()){
	echo '{';
		echo '"message":"product was created."';
	echo '}';
}
//if unable to create the product, tell the user_error
else{
	echo '{';
		echo '"message":"Unable to create product."';
	echo'}';
}
}
//}

?>

