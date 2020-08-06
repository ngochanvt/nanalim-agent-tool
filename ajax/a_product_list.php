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

$params=array();
$shjiaid = $glb_config['lst_shjiaid'];
$sql_count = "SELECT COUNT(*) AS all_record FROM shop_zhibian WHERE 1 = 1 " ;
$sql="";
if(isset($_POST['shjiaid'])){
	$sql.=" AND shjiaid = ? ";
	array_push($params, $_POST['shjiaid']);
}else{
	$k = array_fill(0, count($shjiaid), '?');
  	$k=" (".implode(',', $k).') ';
  	$sql.=" AND shjiaid IN ".$k;
	foreach ($shjiaid as $key => $value) {
  		array_push($params, $key);
  	}
}

if(isset($_POST['anclassid'])){
	$sql.=" AND anclassid = ? ";
	array_push($params, $_POST['anclassid']);
}
if(isset($_POST['nclassid'])){
	$sql.=" AND nclassid = ? ";
	array_push($params, $_POST['nclassid']);
}
if(isset($_POST['xclassid'])){
	$sql.=" AND xclassid = ? ";
	array_push($params, $_POST['xclassid']);
}
if(isset($_POST['gonghuo'])){
	$sql.=" AND gonghuo = ? ";
	array_push($params, $_POST['gonghuo']);
}

if(isset($_POST['shenhe'])){
	$shenhe = json_decode($_POST['shenhe'], true);
	$k = array_fill(0, count($shenhe), '?');
  	$k=" (".implode(',', $k).') ';
	$sql.=" AND shenhe IN  ".$k;
	$params = array_merge($params, $shenhe);
}
if(isset($_POST['kucun'])){
	$sql.=" AND kucun = ? ";
	array_push($params, $_POST['kucun']);
}
if(!empty($searchValue)){
	$search_term = $searchValue;
	$sql.=" AND ( shopname LIKE ? OR shopid LIKE ? OR shopcontent LIKE ? )";
	$params = array_merge($params, array('%'.$search_term.'%', '%'.$search_term.'%', '%'.$search_term.'%'));
}
$sql_count.=$sql;
$sta=$pdo->prepare($sql_count);
$sta->execute($params);
$totalRecords = $sta->fetch(PDO::FETCH_OBJ)->all_record;

$rowMax = $rowperpage + $row;

$sql_normal = "SELECT sz1.* FROM ( SELECT ROW_NUMBER() OVER ( ORDER BY shopid DESC) AS RowID, * FROM shop_zhibian WHERE 1 = 1 ".$sql." ) AS sz1 WHERE sz1.RowID BETWEEN ".$row.' AND '.$rowMax ." ORDER BY sz1.shopid DESC";

$sta=$pdo->prepare($sql_normal);
$sta->execute($params);
$products = $sta->fetchAll(PDO::FETCH_OBJ);

$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => count($products),
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $products
);

echo json_encode($response);
?>