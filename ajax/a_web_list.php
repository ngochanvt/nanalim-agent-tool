<?php
require_once('../config.php');
require_once('../connection.php');
error_reporting(E_ERROR | E_PARSE);
$row = intval($_POST['start']);
$rowperpage = intval($_POST['length']); // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$agency_id = intval($_POST['agency_id']);

$params=array();
$arr_param = array( $agency_id);

$sql = "SELECT 	w.* FROM g5_web w 
		WHERE w.agency_id = ? ";

$sql_common = "";

if($searchValue!=''){
	$sql_common.=" AND (w.web_id LIKE ? OR w.web_name LIKE ? OR w.name LIKE ? OR w.username LIKE ?) ";
	$search_term = '%'.$searchValue.'%';
	array_push($arr_param, $search_term, $search_term, $search_term, $search_term);
}
$sql_common .= " ORDER BY w.web_id ASC LIMIT {$rowperpage} OFFSET {$row}";

$sql.=$sql_common;
try {
    $sta = $pdo->prepare($sql);
	$sta->execute($arr_param);
	$products = $sta->fetchAll(PDO::FETCH_OBJ);
} catch(PDOException $e) {
    echo $e->getMessage();
}


// var_dump($products);

$sql = "SELECT COUNT(id) as totalRecords
        FROM g5_web WHERE agency_id = ?  ";
$arr_param_total[] = $agency_id;

$sql_common = "";
if($searchValue!=''){
	$sql_common.=" AND (web_id LIKE ? OR web_name LIKE ? OR name LIKE ? OR username LIKE ?) ";
	$search_term = '%'.$searchValue.'%';
	$arr_param_total[] = $search_term;
	$arr_param_total[] = $search_term;
	$arr_param_total[] = $search_term;
	$arr_param_total[] = $search_term;
}

$sql.=$sql_common;

$sta = $pdo->prepare($sql);
$sta->execute($arr_param_total);
$totalRecords = $sta->fetch(PDO::FETCH_OBJ)->totalRecords;
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => count($products),
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $products
);

echo json_encode($response);
?>