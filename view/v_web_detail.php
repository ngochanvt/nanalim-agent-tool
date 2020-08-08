<?php
	$sql = "SELECT * FROM g5_web WHERE web_id = ? AND agency_id = ? ";
	$sta = $pdo->prepare($sql);
	$sta->execute(array($_GET['id'], $_SESSION['auth']->agency_id));
	$web = $sta->fetch(PDO::FETCH_OBJ);
?>
<div class="container tab-form">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<form class="row" method="POST" id="form-edit-web" onsubmit="edit_web_info(event)">
				<input type="hidden" name="web_id" id="web_id" value="<?=$_GET['id']?>">
				<div class="col-md-12 form-group">
					<label><?=$cur_lang['website-name']?> <span class="text-red">*</span></label>
				  	<input type="text" class="form-control" name="web_name" id="web_name"  value="<?=$web->web_name?>"  required>
				</div>
				<div class="col-md-6 form-group">
					<label><?=$cur_lang['username']?> <span class="text-red">*</span></label>
				  	<input type="text" class="form-control" name="new-username" id="new-username"  value="<?=$web->username?>"  required autocomplete="off">
				</div>
				<div class="col-md-6 form-group">
					<label><?=$cur_lang['password']?></label>
				  	<input type="password" class="form-control" name="new-password"  value="" id="new-password" autocomplete="new-password">
				</div>

				<div class="col-md-12 form-group">
					<label><?=$cur_lang['manager-name']?></label>
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
				      	<input type="text" class="form-control" name="bank_name" id="bank_name" value="<?=$web->bank_name?>">
				    </div>
				    <div class="col-6 form-group">
				    	<label><?=$cur_lang['bank_branch']?></label>
				      	<input type="text" class="form-control" name="bank_branch" id="bank_branch" value="<?=$web->bank_branch?>">
				    </div>
				    <div class="col-6 form-group">
				    	<label><?=$cur_lang['bank_username']?></label>
				      	<input type="text" class="form-control" name="bank_username" id="bank_username" value="<?=$web->bank_username?>">
				    </div>
				    <div class="col-6 form-group">
				    	<label><?=$cur_lang['bank_number']?></label>
				      	<input type="text" class="form-control" name="bank_number" id="bank_number" value="<?=$web->bank_number?>">
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
	function edit_web_info(event){
		event.preventDefault();
	    var params = {
	    	'update-web-info': 1,
	    	'web_id' : $("#web_id").val(),
	    	'web_name' : $("#web_name").val(),
	        'name' : $("#name").val(),
	        'username': $("#new-username").val(),
	        'password': $("#new-password").val(),
	        'id_number': $("#id_number").val(),
	        'phone' : $("#phone").val(),
	        'email' : $("#email").val(),
	        'address' : $("#address").val(),
	        'bank_name' : $("#bank_name").val(),
	        'bank_branch' : $("#bank_branch").val(),
	        'bank_username' : $("#bank_username").val(),
	        'bank_number' : $("#bank_number").val()
	    }
	    SERVICE.web(params, function(resp){
	    	bootbox.alert(resp.message, function(){
	    		location.reload();
	    	});
	    	
	    	
	    })
	}
</script>