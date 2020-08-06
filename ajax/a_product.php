<?php
require_once('../config.php');
require_once('../connection.php');
error_reporting(E_ERROR | E_PARSE);
header('Content-type: application/json');
if(isset($_POST['detele-shopid'])){
	$exclude_shopids = array();
	$include_shopids = array();
	$check_all_shopid = $_POST['check_all_shopid'];
	if($check_all_shopid==1){
		$exclude_shopids = json_decode($_POST['exclude_shopids'], true);
		foreach ($exclude_shopids as $key => $value) {
			$exclude_shopids[$key] = intval($value);
		}
		$sql="SELECT shopid FROM ref_product_shjiaid WHERE id_gen IN (SELECT id_gen FROM ref_product_shjiaid WHERE shopid NOT IN ";

		$k = array_fill(0, count($exclude_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k . ' ) ';

		$sta=$pdo->prepare($sql);
		$sta->execute($exclude_shopids);
		$ref_shopid=$sta->fetchAll(PDO::FETCH_OBJ);
		if($ref_shopid!=null && count($ref_shopid)>0){
			foreach ($ref_shopid as $key => $value) {
				if(!in_array($value->shopid, $exclude_shopids)){
					array_push($exclude_shopids, intval($value->shopid));
				}
			}
		}

		$sql="DELETE FROM shop_zhibian WHERE shopid NOT IN ";
		$k = array_fill(0, count($exclude_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k;
		
		$sql.="DELETE FROM ref_product_shjiaid WHERE shopid NOT IN ";
		$sql.=$k;
		$sta=$pdo->prepare($sql);
		$status = $sta->execute(array_merge($exclude_shopids, $exclude_shopids));

		$response = array(
		  "status" => $status
		);

	}else{
		$include_shopids = json_decode($_POST['include_shopids'], true);
		foreach ($include_shopids as $key => $value) {
			$include_shopids[$key] = intval($value);
		}
		$sql="SELECT shopid FROM ref_product_shjiaid WHERE id_gen IN (SELECT id_gen FROM ref_product_shjiaid WHERE shopid IN ";

		$k = array_fill(0, count($include_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k . ' ) ';

		$sta=$pdo->prepare($sql);
		$sta->execute($include_shopids);
		$ref_shopid=$sta->fetchAll(PDO::FETCH_OBJ);
		if($ref_shopid!=null && count($ref_shopid)>0){
			foreach ($ref_shopid as $key => $value) {
				if(!in_array($value->shopid, $include_shopids)){
					array_push($include_shopids, intval($value->shopid));
				}
			}
		}

		$sql="DELETE FROM shop_zhibian WHERE shopid IN ";
		$k = array_fill(0, count($include_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k;

		$sql.="DELETE FROM ref_product_shjiaid WHERE shopid IN ";
		$sql.=$k;
		$sta=$pdo->prepare($sql);
		$status = $sta->execute(array_merge($include_shopids, $include_shopids));

		$response = array(
		  "status" => $status
		);
	}
	echo json_encode($response);
}
if(isset($_POST['sold-out'])){
	if($check_all_shopid==1){
		$exclude_shopids = json_decode($_POST['exclude_shopids'], true);
		foreach ($exclude_shopids as $key => $value) {
			$exclude_shopids[$key] = intval($value);
		}
		$sql="SELECT shopid FROM ref_product_shjiaid WHERE id_gen IN (SELECT id_gen FROM ref_product_shjiaid WHERE shopid NOT IN ";
		$k = array_fill(0, count($exclude_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k . ' ) ';

		$sta=$pdo->prepare($sql);
		$sta->execute($exclude_shopids);
		$ref_shopid=$sta->fetchAll(PDO::FETCH_OBJ);
		if($ref_shopid!=null && count($ref_shopid)>0){
			foreach ($ref_shopid as $key => $value) {
				if(!in_array($value->shopid, $exclude_shopids)){
					array_push($exclude_shopids, intval($value->shopid));
				}
			}
		}

		$sql="UPDATE shop_zhibian SET shenhe = ? WHERE shopid NOT IN ";
		$k = array_fill(0, count($exclude_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k;
		$sta=$pdo->prepare($sql);
		$param = array($_POST['shenhe']);
		$status = $sta->execute(array_merge($param, $exclude_shopids));

		$response = array(
		  "status" => $status
		);

	}else{
		$include_shopids = json_decode($_POST['include_shopids'], true);
		foreach ($include_shopids as $key => $value) {
			$include_shopids[$key] = intval($value);
		}
		$sql="SELECT shopid FROM ref_product_shjiaid WHERE id_gen IN ( SELECT id_gen FROM ref_product_shjiaid WHERE shopid IN ";

		$k = array_fill(0, count($include_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k . ' ) ';
		$sta=$pdo->prepare($sql);
		$sta->execute($include_shopids);
		$ref_shopid=$sta->fetchAll(PDO::FETCH_OBJ);
		if($ref_shopid!=null && count($ref_shopid)>0){
			foreach ($ref_shopid as $key => $value) {
				if(!in_array($value->shopid, $include_shopids)){
					array_push($include_shopids, intval($value->shopid));
				}
			}
		}

		$sql="UPDATE shop_zhibian SET shenhe = ? WHERE shopid IN ";
		$k = array_fill(0, count($include_shopids), '?');
		$k = " ( ".implode(',', $k).' ) ';
		$sql.=$k;
		$sta=$pdo->prepare($sql);
		$param = array($_POST['shenhe']);
		$status = $sta->execute(array_merge($param, $include_shopids));

		$response = array(
		  "status" => $status
		);
	}
	// $shopid=$_POST['shopid'];
	// $sql="SELECT shopid FROM ref_product_shjiaid WHERE id_gen = (SELECT id_gen FROM ref_product_shjiaid WHERE shopid = ? )";
	// $sta=$pdo->prepare($sql);
	// $sta->execute(array($shopid));
	// $ref_shopid=$sta->fetchAll(PDO::FETCH_OBJ);
	// $lst_shopid=array();
	// if($ref_shopid!=null && count($ref_shopid)>0){
	// 	foreach ($ref_shopid as $key => $value) {
	// 		array_push($lst_shopid, $value->shopid);
	// 	}
	// }else{
	// 	array_push($lst_shopid, $shopid);
	// }

	// $sql="UPDATE shop_zhibian SET shenhe = ? WHERE shopid IN ";
	// $k = array_fill(0, count($lst_shopid), '?');
	// $k = " ( ".implode(',', $k).' ) ';
	// $sql.=$k;
	// $sta=$pdo->prepare($sql);
	// $param = array($_POST['shenhe']);
	// $status = $sta->execute(array_merge($param, $lst_shopid));

	// $response = array(
	//   "status" => $status
	// );

	echo json_encode($response);
}
?>