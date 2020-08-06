<?php
require_once('../config.php');
require_once('../connection.php');
error_reporting(E_ERROR | E_PARSE);

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$id = $_POST['id'];
$status = $_POST['status'];
$params=array();

$completed = 'COMPLETED';
$requested = 'REQUESTED';
$sql = '';
$arr_param = array();

$sql = "SELECT o.od_id, o.od_name, (o.od_cart_price+o.od_send_cost+o.od_send_cost2) as od_receipt_price, o.od_receipt_time, (o.od_cart_price+o.od_send_cost+o.od_send_cost2)*0.1 as commission, wo.*, ap.payment_date, ap.status 
		FROM g5_shop_order o INNER JOIN g5_web_order wo ON o.od_id = wo.order_id
							 LEFT JOIN g5_agency_payment ap ON ap.payment_code = wo.ap_code
		WHERE wo.web_id = ? ";

$arr_param = array($id);

$sql_common = "";
if($status=='all'){
	$sql_common.=" AND (ap.status = ? OR ap.status = ? OR ap.status = ?) ";
	array_push($arr_param, '', 'COMPLETED', 'REQUESTED');
}else if($status=='non'){
	$sql_common.=" AND wo.ap_code = ? ";
	array_push($arr_param, '');
}
else{
	$sql_common.=" AND ap.status = ? ";
	array_push($arr_param, $status);
}
if($searchValue!=''){
	$sql_common.=" AND (o.od_name LIKE ?) ";
	$search_term = '%'.$searchValue.'%';
	array_push($arr_param, $search_term);
}
$sql_common .= " ORDER BY o.od_id DESC LIMIT {$rowperpage} OFFSET {$row}";

$sql.=$sql_common;
// var_dump($sql);
$sta = $pdo->prepare($sql);
$sta->execute($arr_param);
$products = $sta->fetchAll(PDO::FETCH_OBJ);

$sql = '';
$arr_param_total = array();
$params_type_total = '';
$sql = "SELECT COUNT(o.od_id) AS totalRecords
		FROM g5_shop_order o INNER JOIN g5_web_order wo ON o.od_id = wo.order_id
							 LEFT JOIN g5_agency_payment ap ON ap.payment_code = wo.ap_code
		WHERE wo.web_id = ? ";

$arr_param = array($id);

$sql_common = "";
if($status=='all'){
	$sql_common.=" AND (ap.status = ? OR ap.status = ? OR ap.status = ?) ";
	array_push($arr_param, '', 'COMPLETED', 'REQUESTED');
}else{
	$sql_common.=" AND ap.status = ? ";
	array_push($arr_param, $status);
}
if($searchValue!=''){
	$sql_common.=" AND (o.od_name LIKE ?) ";
	$search_term = '%'.$searchValue.'%';
	array_push($arr_param, $search_term);
}

$sql.=$sql_common;
$sta = $pdo->prepare($sql);
$sta->execute($arr_param);

$totalRecords =  $sta->fetch(PDO::FETCH_OBJ)->totalRecords;
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => count($products),
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $products
);

echo json_encode($response);
?>