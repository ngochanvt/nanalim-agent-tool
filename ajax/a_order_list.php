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
$payment_type = $_POST['payment_type'];
$params=array();

$completed = 'COMPLETED';
$requested = 'REQUESTED';
$sql = '';
$arr_param = array();

$sql = "SELECT o.od_id, o.od_name, (o.od_cart_price+o.od_send_cost+o.od_send_cost2) as od_receipt_price, o.od_receipt_time, (o.od_cart_price+o.od_send_cost+o.od_send_cost2)*0.1 as commission, w.* 
		FROM g5_shop_order o INNER JOIN g5_web_order w ON o.od_id = w.order_id
		WHERE w.ap_code = ? ";

$arr_param = array($id);

$sql_common = "";
if($searchValue!=''){
	$sql_common.=" AND (o.od_name LIKE ?) ";
	$search_term = '%'.$searchValue.'%';
	array_push($arr_param, $search_term);
}
$sql_common .= " ORDER BY o.od_id DESC LIMIT {$rowperpage} OFFSET {$row}";

$sql.=$sql_common;

$sta = $pdo->prepare($sql);
$sta->execute($arr_param);
$products = $sta->fetchAll(PDO::FETCH_OBJ);

$sql = '';
$arr_param_total = array();
$params_type_total = '';
$sql = "SELECT COUNT(o.od_id) AS totalRecords
		FROM g5_shop_order o INNER JOIN g5_web_order w ON o.od_id = w.order_id
		WHERE w.ap_code = ? ";

$arr_param = array($id);

$sql_common = "";
if($searchValue!=''){
	$sql_common.=" AND (od_name LIKE ?) ";
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