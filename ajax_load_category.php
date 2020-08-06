<?php
require_once('./connection.php');
if(isset($_POST['load_nclassid'])){
	header('Content-type: application/json');
	$data_return = new stdClass();
	$sql="SELECT nclass, nclassid FROM shop_nclass WHERE shjiaid = ? AND anclassid = ?";
	$sta=$pdo->prepare($sql);
	$shop_nclass = array();
	$sta->execute(array(1, $_POST['anclassid']));
	$shop_nclass = $sta->fetchAll(PDO::FETCH_OBJ);
	$data_return->notification = (object)['code'=>200, 'message'=>'Success'];
	$data_return->shop_nclass  = $shop_nclass;
	echo json_encode($data_return);
}
if(isset($_POST['load_xclassid'])){
	header('Content-type: application/json');
	$data_return = new stdClass();
	$sql="SELECT id, xclass FROM shop_xclass WHERE shjiaid = ? AND nclassid = ?";
	$sta=$pdo->prepare($sql);
	$shop_nclass = array();
	$sta->execute(array(1, $_POST['nclassid']));
	$shop_xclass = $sta->fetchAll(PDO::FETCH_OBJ);
	$data_return->notification = (object)['code'=>200, 'message'=>'Success'];
	$data_return->shop_xclass  = $shop_xclass;
	echo json_encode($data_return);
}
?>