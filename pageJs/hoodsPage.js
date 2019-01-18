//for the hoods js
$(Document).ready(function(){
$.ajax({
	url:'readProductsCategory.php?category_id=6718hmj0ZT60xyU',
	method:'GET',
	dataType:'json',
	headers:{
			'Content-Type': 'application/json'
	},
	processData:false,
	success:function(responseData){
		//Process the data
		$('#content').empty();
		console.log(JSON.stringify(responseData));
		
		ResponsePC=JSON.parse(JSON.stringify(responseData));
		for(var key in ResponsePC){
			if(ResponsePC.hasOwnProperty(key)){
				
				$('#content').append('<div class="col-sm-6 col-md-4 col-lg-3 mb-2 mt-2"><!-- Card Narrower --><div class="card card-cascade narrower"><!-- Card image --><div class="view  overlay zoom"><img  class="card-img-top" src="Admin/'+ResponsePC[key].image_url+'"  class="img-fluid" alt="'+ResponsePC[key].name+'"><a><div class="mask flex-center"></div></a></div><!-- Card content --><div class="card-body card-body-cascade"><!-- Label --><h6 class="pink-text"><i class="fa fa-male"></i>'+ResponsePC[key].category_name+'</h6><!-- Title --><h5 class="font-weight-bold card-title">'+ResponsePC[key].name+'</h5><!-- Text --><p>'+ResponsePC[key].description+'</p><p class="green-text">'+ResponsePC[key].price+'</p></div></div></div>');
			}
		}
	},
	error:function(error){
		//process the error
		console.log(JSON.stringify(error));
		$('#content').empty();
		$('#errorMSG').html("An error occurred. Please try again later!");
		$('#ErrorM').modal('show');
	}
});
});