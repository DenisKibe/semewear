//for the get all products
$(document).ready(function(){
	$.ajaxSetup({
		headers:{
				'Content-Type':'application/json',
				'Authorization':'bearer '+sessionStorage.session
			}
	});
			
$.ajax({
	url:'readProducts.php',
	method:'GET',
	dataType:'json',
	processData:false,
	success:function(responseData){
		//do something with the data
		$('#content').empty();
		console.log(JSON.stringify(responseData));
		
		ResponsePC=JSON.parse(JSON.stringify(responseData));
		for(var key in ResponsePC){
			if(ResponsePC.hasOwnProperty(key)){
				$('#content').append('<div class="col-sm-6 col-md-4 col-lg-3 mb-2 mt-2"><!-- Card Narrower --><div class="card card-cascade narrower"><!-- Card image --><div class="view  overlay zoom"><img  class="card-img-top" src="'+ResponsePC[key].image_url+'"  class="img-fluid" alt="'+ResponsePC[key].name+'"><a><div class="mask flex-center"></div></a></div><!-- Card content --><div class="card-body card-body-cascade"><!-- Label --><h6 class="pink-text"><i class="fa fa-male"></i>'+ResponsePC[key].category_name+'</h6><!-- Title --><h5 class="font-weight-bold card-title">'+ResponsePC[key].name+'</h5><!-- Text --><p>'+ResponsePC[key].description+'</p><p class="green-text">'+ResponsePC[key].price+'</p></div><div class="card-footer"><button type="edit" class="btn btn-default btn-sm mx-0 float-left" data-toggle="modal" data-target="#editModal" id="'+ResponsePC[key].id+'">EDIT</button><button type="reset" class="btn btn-primary btn-sm mx-0 float-right" id="'+ResponsePC[key].id+'">DELETE</button></div></div></div>');
			}
		}
	},
	error:function(error){
		//do something with the error
		console.log(JSON.stringify(error));
		$('#content').empty();
		$('#errorMSG').html("An error occurred. Please try again later!");
		$('#ErrorM').modal('show');
	}
});
var BtnId;
//for the delete product
jQuery(document).delegate('#content button[type="reset"]','click',function(event){
	event.preventDefault();
	
	BtnId=$(this).attr('id');
	
	console.log(BtnId);
	
	var confirmD=confirm("you are about to Delete the product "+BtnId);
	
	if(confirmD){
		$.ajax({
			url:'delete.php',
			method:'POST',
			dataType:'json',
			data:JSON.stringify({'id':BtnId}),
			success:function(responseData){
				console.log(JSON.stringify(responseData));
				
				//update the page
				$.ajax({
	url:'readProducts.php',
	method:'GET',
	dataType:'json',
	processData:false,
	success:function(responseData){
		//do something with the data
		$('#content').empty();
		console.log(JSON.stringify(responseData));
		
		ResponsePC=JSON.parse(JSON.stringify(responseData));
		for(var key in ResponsePC){
			if(ResponsePC.hasOwnProperty(key)){
				$('#content').append('<div class="col-sm-6 col-md-4 col-lg-3 mb-2 mt-2"><!-- Card Narrower --><div class="card card-cascade narrower"><!-- Card image --><div class="view  overlay zoom"><img  class="card-img-top" src="'+ResponsePC[key].image_url+'"  class="img-fluid" alt="'+ResponsePC[key].name+'"><a><div class="mask flex-center"></div></a></div><!-- Card content --><div class="card-body card-body-cascade"><!-- Label --><h6 class="pink-text"><i class="fa fa-male"></i>'+ResponsePC[key].category_name+'</h6><!-- Title --><h5 class="font-weight-bold card-title">'+ResponsePC[key].name+'</h5><!-- Text --><p>'+ResponsePC[key].description+'</p><p class="green-text">'+ResponsePC[key].price+'</p></div><div class="card-footer"><button type="edit" class="btn btn-default btn-sm mx-0 float-left" data-toggle="modal" data-target="#editModal" id="'+ResponsePC[key].id+'">EDIT</button><button type="reset" class="btn btn-primary btn-sm mx-0 float-right" id="'+ResponsePC[key].id+'">DELETE</button></div></div></div>');
			}
		}
	},
	error:function(error){
		//do something with the error
		console.log(JSON.stringify(error));
		$('#content').empty();
	}
});
				
				
				$('#successMSG').html("Success product Deleted successfully");
				$('#SuccessM').modal('show');
			},
			error:function(error){
				console.log(JSON.stringify(error));
				$('#errorMSG').html("Failed! Try again!");
				$('#ErrorM').modal('show');
			}
		});
	}	
});
//for the edit product
jQuery(document).delegate('#content button[type="edit"]','click',function(event){
	event.preventDefault();
	
	BtnId=$(this).attr('id');
	
	console.log(BtnId);
});
//to edit product
$('#subEdit').click(function(event){
	event.preventDefault();
	
	var name=$('#pName').val();
	var price=$('#pPrice').val();
	var description=$('#pDescrition').val();
	var categoryName=$('#pCatergory').val();
	
	
	
		$.ajax({
			url:'update.php',
			method:'POST',
			dataType:'json',
			data:JSON.stringify({'id':BtnId,'name':name,'price':price,'description':description,'category_name':categoryName}),
			success:function(responseData){
				console.log(JSON.stringify(responseData));
				
				//update the page
				$.ajax({
	url:'readProducts.php',
	method:'GET',
	dataType:'json',
	processData:false,
	success:function(responseData){
		//do something with the data
		$('#content').empty();
		console.log(JSON.stringify(responseData));
		
		ResponsePC=JSON.parse(JSON.stringify(responseData));
		for(var key in ResponsePC){
			if(ResponsePC.hasOwnProperty(key)){
				$('#content').append('<div class="col-sm-6 col-md-4 col-lg-3 mb-2 mt-2"><!-- Card Narrower --><div class="card card-cascade narrower"><!-- Card image --><div class="view  overlay zoom"><img  class="card-img-top" src="'+ResponsePC[key].image_url+'"  class="img-fluid" alt="'+ResponsePC[key].name+'"><a><div class="mask flex-center"></div></a></div><!-- Card content --><div class="card-body card-body-cascade"><!-- Label --><h6 class="pink-text"><i class="fa fa-male"></i>'+ResponsePC[key].category_name+'</h6><!-- Title --><h5 class="font-weight-bold card-title">'+ResponsePC[key].name+'</h5><!-- Text --><p>'+ResponsePC[key].description+'</p><p class="green-text">'+ResponsePC[key].price+'</p></div><div class="card-footer"><button type="edit" class="btn btn-default btn-sm mx-0 float-left" data-toggle="modal" data-target="#editModal" id="'+ResponsePC[key].id+'">EDIT</button><button type="reset" class="btn btn-primary btn-sm mx-0 float-right" id="'+ResponsePC[key].id+'">DELETE</button></div></div></div>');
			}
		}
	},
	error:function(error){
		//do something with the error
		console.log(JSON.stringify(error));
		$('#content').empty();
		
	}
});
				
				
				$('#successMSG').html("Success product Edited successfully");
				$('#SuccessM').modal('show');
			},
			error:function(error){
				console.log(JSON.stringify(error));
				$('#errorMSG').html("Failed! Try again!");
				$('#ErrorM').modal('show');
			}
		});	
});
});