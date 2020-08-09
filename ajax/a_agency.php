<?php
require_once('../config.php');
require_once('../connection.php');
error_reporting(E_ERROR | E_PARSE);
header('Content-type: application/json');
$response = array(
	"message" => $cur_lang["success"],
	"status" => 200
);
if(isset($_POST['update-agency-info'])){
	$arr_params = array();
	$arr_field = array();


	if(isset($_POST['username']) && !empty($_POST['username'])){
		$sql_check = "SELECT COUNT(agency_id) as COUNT_AGENCY FROM g5_agency WHERE username = ? AND agency_id <> ?";
		$sta = $pdo->prepare($sql_check);
		$sta->execute(array($_POST['username'], $_POST['agency_id']));
		$exit_username = $sta->fetch(PDO::FETCH_OBJ)->COUNT_AGENCY;
		if($exit_username>0) {
			$response = array(
				"message" => $cur_lang["exist_username"],
				"status" => 403
			);
			goto end_api;
		}
	}

	$sql = "UPDATE g5_agency SET ";
	if(isset($_POST['password']) && !empty($_POST['password'])){
		array_push($arr_field, ' password = ? ');
		array_push($arr_params, md5($_POST['password']));
	}
	if(isset($_POST['name']) && !empty($_POST['name'])){
		array_push($arr_field, ' name = ? ');
		array_push($arr_params, $_POST['name']);
	}
	if(isset($_POST['username']) && !empty($_POST['username'])){
		array_push($arr_field, ' username = ? ');
		array_push($arr_params, $_POST['username']);
	}
	if(isset($_POST['id_number']) && !empty($_POST['id_number'])){
		array_push($arr_field, ' id_number = ? ');
		array_push($arr_params, $_POST['id_number']);
	}
	if(isset($_POST['phone']) && !empty($_POST['phone'])){
		array_push($arr_field, ' phone = ? ');
		array_push($arr_params, $_POST['phone']);
	}
	if(isset($_POST['email']) && !empty($_POST['email'])){
		array_push($arr_field, ' email = ? ');
		array_push($arr_params, $_POST['email']);
	}
	if(isset($_POST['address']) && !empty($_POST['address'])){
		array_push($arr_field, ' address = ? ');
		array_push($arr_params, $_POST['address']);
	}
	if(isset($_POST['bank_name']) && !empty($_POST['bank_name'])){
		array_push($arr_field, ' bank_name = ? ');
		array_push($arr_params, $_POST['bank_name']);
	}
	if(isset($_POST['bank_branch']) && !empty($_POST['bank_branch'])){
		array_push($arr_field, ' bank_branch = ? ');
		array_push($arr_params, $_POST['bank_branch']);
	}
	if(isset($_POST['bank_username']) && !empty($_POST['bank_username'])){
		array_push($arr_field, ' bank_username = ? ');
		array_push($arr_params, $_POST['bank_username']);
	}
	if(isset($_POST['bank_number']) && !empty($_POST['bank_number'])){
		array_push($arr_field, ' bank_number = ? ');
		array_push($arr_params, $_POST['bank_number']);
	}
	if(count($arr_params)>0){
		$sql .= implode(', ', $arr_field)." WHERE agency_id = ? ";
		array_push($arr_params, $_POST['agency_id']);
		$sta = $pdo->prepare($sql);
		$status = $sta->execute($arr_params)?200:403;
		$response = array(
			"message" => $status==200?$cur_lang["success"]:$cur_lang["error"],
			"status" => $status
		);
		if((isset($_POST['password']) && !empty($_POST['password']))){
			unset($_SESSION['auth']);
		}
	}
}
end_api:
echo json_encode($response);
?>