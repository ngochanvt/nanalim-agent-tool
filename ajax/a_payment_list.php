<?php
require_once('../config.php');
require_once('../connection.php');
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$agency_id = $_POST['agency_id'];
$params=array();

$sql = "SELECT * 
		FROM g5_agency_payment
		WHERE agency_id = ?";

$arr_param = array($agency_id);

$sql_common = "";
if($searchValue!=''){
	$sql_common.=" AND (payment_code LIKE ?) ";
	$search_term = '%'.$searchValue.'%';
	array_push($arr_param, $search_term);
}
$sql_common .= " ORDER BY create_date DESC LIMIT {$rowperpage} OFFSET {$row}";

$sql.=$sql_common;

$sta=$pdo->prepare($sql);
$sta->execute($arr_param);
$products = $sta->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT COUNT(payment_code) as totalRecords
        FROM g5_agency_payment
		WHERE agency_id = ? ";

$arr_param = array($agency_id);

$sql_common = "";
if($searchValue!=''){
	$sql_common.=" AND (payment_code LIKE ?) ";
	$search_term = '%'.$searchValue.'%';
	array_push($arr_param, $search_term);
}

$sql.=$sql_common;

$sta=$pdo->prepare($sql);
$sta->execute($arr_param);
$totalRecords = $sta->fetch(PDO::FETCH_OBJ)->totalRecords;
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => count($products),
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $products
);

echo json_encode($response);
?>