
//admin index page js
$(document).ready(function(){
$('#subAdmin').click(function(event){
event.preventDefault();
	var username=$('#uName').val();
	var password=$('#pWord').val();
	
	if(username == '' || password ==''){
		alert("failed this fields cannot be empty!");
		return false;
	}
	
	$.ajax({
          	url:'adminLogin.php',
		method:'POST',
		dataType:'json',
		headers:{
			'Content-Type': 'application/json'
		},
		data:JSON.stringify({'username':username,'password':password}),
		success:function(ResponseData){
			//do something with the response data
			console.log(JSON.stringify(ResponseData));
			var ResponseD=JSON.parse(JSON.stringify(ResponseData));
			if(typeof(Storage)!=="undefined"){
				sessionStorage.session=ResponseD.access_token;
				
				window.location="getProducts.html";
			}else{
				alert("Please use a modern browser");
			}
			
				
		},
		error:function(error){
			//do something with the error
			console.log(JSON.stringify(error));
			
			var ResponseD=JSON.parse(JSON.stringify(error));
			
			alert(ResponseD.responseText);
			
		}


	});
	});
	});