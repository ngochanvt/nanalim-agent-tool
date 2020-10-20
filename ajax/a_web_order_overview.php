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
$web_id = isset($_POST['web_id'])?$_POST['web_id']:'';

$params=array();
$arr_param = array();

$sql = "SELECT 	w.web_id, w.web_name, 
				COUNT(DISTINCT wo.order_id) as total_order,
				COUNT(DISTINCT wo_non.order_id) as total_non_payemnt,
				COUNT(DISTINCT ap_c.order_id) as total_complete_payment,
				COUNT(DISTINCT ap_r.order_id) as total_request_payment
		FROM g5_web w LEFT JOIN g5_web_order wo ON w.web_id = wo.web_id 
					  LEFT JOIN g5_agency_payment ap ON ap.agency_id = w.agency_id 
					  LEFT JOIN g5_web_order wo_non ON w.web_id = wo_non.web_id AND wo_non.ap_code = ?
					  LEFT JOIN g5_web_order ap_c ON w.web_id = ap_c.web_id AND ap_c.ap_code <> ? AND ap.status = ?
					  LEFT JOIN g5_web_order ap_r ON w.web_id = ap_r.web_id AND ap_r.ap_code <> ? AND ap.status = ?
		WHERE w.status<>-1 AND w.agency_id = ?";

$sql_common = "";
array_push($arr_param, '', '', 'COMPLETED', '', 'REQUESTED', $agency_id);
if($web_id!=''){
	$sql_common.=" AND w.id = ? ";
	array_push($arr_param, $web_id);
}

if($searchValue!=''){
	$sql_common.=" AND (w.web_id LIKE ? OR w.web_name LIKE ? ) ";
	$search_term = '%'.$searchValue.'%';
	array_push($arr_param, $search_term, $search_term);
}
$sql_common .= " GROUP BY w.web_id, w.web_name ORDER BY w.web_id ASC LIMIT {$rowperpage} OFFSET {$row}";

$sql.=$sql_common;
// var_dump($sql);
// var_dump($arr_param);
try {
    $sta = $pdo->prepare($sql);
	$sta->execute($arr_param);
	$products = $sta->fetchAll(PDO::FETCH_OBJ);
} catch(PDOException $e) {
    echo $e->getMessage();
}


// var_dump($products);

$sql = "SELECT COUNT(id) as totalRecords
        FROM g5_web WHERE status  = ? AND agency_id = ?  ";
$arr_param_total[] = 1;
$arr_param_total[] = $agency_id;

$sql_common = "";
if($searchValue!=''){
	$sql_common.=" AND (web_id LIKE ? OR web_name LIKE ? ) ";
	$search_term = '%'.$searchValue.'%';
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