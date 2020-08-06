<?php
	$sql = "SELECT * FROM g5_web WHERE web_id = ? AND agency_id = ? ";
	$sta = $pdo->prepare($sql);
	$sta->execute(array($_GET['id'], $_SESSION['auth']->agency_id));
	$web = $sta->fetch(PDO::FETCH_OBJ);
?>
<div class="container tab-form">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<form class="row" method="POST" id="form-edit-web" onsubmit="create_order(event)">
				<div class="col-md-12 form-group">
					<label><?=$cur_lang['website-name']?> <span class="text-red">*</span></label>
				  	<input type="text" class="form-control" name="web_name" id="web_name"  value="<?=$web->web_name?>"  required>
				</div>
				<div class="col-md-6 form-group">
					<label><?=$cur_lang['username']?> <span class="text-red">*</span></label>
				  	<input type="text" class="form-control" name="username" id="username"  value="<?=$web->username?>"  required>
				</div>
				<div class="col-md-6 form-group">
					<label><?=$cur_lang['password']?></label>
				  	<input type="password" class="form-control" name="password"  value="" id="password" >
				</div>

				<div class="col-md-12 form-group">
					<label><?=$cur_lang['name']?></label>
				  	<input type="text" class="form-control" name="name"  value="<?=$web->name?>" id="name" >
				</div>

				<div class="col-md-12 form-group">
					<label><?=$cur_lang['id_number']?></label>
				  	<input type="text" class="form-control" name="id_number"  value="<?=$web->id_number?>" id="id_number" >
				</div>

				<div class="col-md-6 form-group">
					<label><?=$cur_lang['telephone']?></label>
				  	<input type="text" class="form-control" name="phone"  value="<?=$web->phone?>" id="phone" >
				</div>
				<div class="col-md-6 form-group">
					<label><?=$cur_lang['email']?></label>
				  	<input type="text" class="form-control" name="email"  value="<?=$web->email?>" id="email" >
				</div>

				<div class="col-md-12 form-group">
					<label><?=$cur_lang['address']?> </label>
				  	<input type="text" class="form-control" name="address"  value="<?=$web->address?>" id="address"  required>
				</div>


				<div class="row p-0" style="background: Cornsilk; margin: 15px 0;">
			    	<hr class="col-12 m-0 p-0">
				    <div class="col-12">
				    	<h5><?=$cur_lang['bank_info']?></h5>
				    </div>
				    
				    <div class="col-6 form-group">
				    	<label><?=$cur_lang['bank_name']?></label>
				      	<input type="text" class="form-control" name="bank_name" value="<?=$web->bank_name?>">
				    </div>
				    <div class="col-6 form-group">
				    	<label><?=$cur_lang['bank_branch']?></label>
				      	<input type="text" class="form-control" name="bank_branch" value="<?=$web->bank_branch?>">
				    </div>
				    <div class="col-6 form-group">
				    	<label><?=$cur_lang['bank_username']?></label>
				      	<input type="text" class="form-control" name="bank_username" value="<?=$web->bank_username?>">
				    </div>
				    <div class="col-6 form-group">
				    	<label><?=$cur_lang['bank_number']?></label>
				      	<input type="text" class="form-control" name="bank_number" value="<?=$web->bank_number?>">
				    </div>
				    <hr class="col-12 m-0 p-0">
			    </div>

				<div class="col-12 form-group m-1 text-right">
					<button type="submit" name="add-company" class="btn btn-default"><?=$cur_lang['save']?></button>
				</div>
			 </form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function create_order(event){
		event.preventDefault();
	    var params = {
	    	'create-order': 1,
	        'receive_name' : $("#receive_name").val(),
	        'address' : $("#address").val(),
	        'phone' : $("#phone").val(),
	        'note': $("#note").val(),
	        'receive_email': $("#receive_email").val()
	    }
	    var count = 0;
	    for(var i=0; i<product_num; i++){
	    	if(deleted_product.indexOf(i)==-1){
	    		params['product_name_'+count] = $("#product_name_"+i).val();
	    		params['product_code_'+count] = $("#product_code_"+i).val();
	    		params['quantity_'+count] = $("#quantity_"+i).val();
	    		count += 1;
	    	}
	    }
	    params['product_num'] = count;
	    SERVICE.create_order(params, function(resp){
	    	bootbox.alert(resp.message, function(){
	    		if(resp.status==200){
	    			$("#form-create-order").trigger('reset');
	    		}
	    	});
	    	
	    	
	    })
	}
</script>