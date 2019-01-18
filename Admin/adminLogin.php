<?php
//required headers_list
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;");
header("Access-Control-Allow-Methods:POST");

include_once 'database.php';
include_once 'jwtGen.php';

//get database connection
$database=new Database();
$db=$database->getConnection();

//get users data in json
$data=json_decode(file_get_contents("php://input"));
$heads=getallheaders();

if($_SERVER['REQUEST_METHOD'] !='POST'){
	//set response code
	http_response_code(400);
	//echo the error
	die('Invalid request method, Only POST request method allowed');
}else{

	
	$uname=htmlspecialchars(strip_tags($data->{'username'}));
	$pword=htmlspecialchars(strip_tags($data->{'password'}));

	$query="SELECT * FROM admin_cd WHERE uName=:username AND pWord=:password";

//prepare query statemant
$stmt=$db->prepare($query);

//bind new values
$stmt->bindParam(':username',$uname);
$stmt->bindParam(':password',$pword);

//execute the query
$stmt->execute();
if($stmt->execute()){
        $row=$stmt->rowCount();

        if($row>0){
        http_response_code(200);
                
                $access_token=generator($pword);
		$user=array("token_type"=>"bearer","access_token"=>$access_token);
		echo(json_encode($user));		
        }else{
                //set response code to (400)
				http_response_code(400);
				
                die('Invalid Login');
        }
}else{
	//set response code to (400)
	http_response_code(400);
die('Failed!');
}
}
?>
