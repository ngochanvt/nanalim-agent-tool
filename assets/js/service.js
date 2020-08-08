var SERVICE = {
	web: function(params, handledata){
		$.ajax({
	        type: "POST",
	        url: base_url + 'ajax/a_web.php',
	        data: params,
	        success: function(data)
	           {
	           		handledata(data);
	                
	           }
	     });
	}
}