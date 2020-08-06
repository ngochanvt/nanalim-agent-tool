<script >
$(document).ready(function(){
	$( "#datepicker" ).datepicker({
		dateFormat: "yy-mm-dd",
      	changeMonth: true,
      	changeYear: true
    });
	$('#img-iden').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
	    	$(".mau").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
	    	$(".image-name").val($('#img-iden').val());
	});
	$( "#speed" ).change(function() {
		
	  	var id_post=$(this).val();
	  	$.ajax({
	  		type: 'POST',
			url: './ajax/ajax_load_place.php',
			data: {id_post:id_post},
			success: function(data){
				//alert(data);
				$("#speed1").html(data);
			}
	  	});
	  });
	$( "#speed1" ).change(function() {
	  	//alert("aaa");
	  	var id_place=$(this).val();
	  	var id_post=$( "#speed" ).val();
	  	$.ajax({
	  		type: 'POST',
			url: './ajax/ajax_load_scheldule.php',
			data: {id_place:id_place,id_post:id_post},
			success: function(data){
				//alert(data);
				$("#speed2").html(data);
			}
	  	});
	  });
	
})
</script>