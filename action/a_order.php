<pre>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config.php');
require_once('../connection.php');
if(isset($_POST['update-status-order'])){
	$todate = date('Y-m-d H:i:s.v');
	$dingdan = $_POST['dingdan'];
	$username = $_POST['username'];
	$params=array($_POST['wuliu'], $_POST['feiyong'], $todate);
	$old_zhuangtai = intval($_POST['old_zhuangtai']);
	$zhuangtai = intval($_POST['zhuangtai']);
	$sql="UPDATE shop_action SET wuliu=?, feiyong=?, fhsj=? ";
	if($_POST['zhuangtai']!=''){
		$sql.=", zhuangtai=?";
		array_push($params, $_POST['zhuangtai']);
		if($zhuangtai==2){
			$sql.=", qlr=?";
			array_push($params, 'zhibian01,'.$todate); 
		}else if($zhuangtai==3){
			$sql.=", qlr1=? ";
			array_push($params, 'zhibian01,'.$todate);
		}else if($zhuangtai==4){
			$sql.=", qlr2=?, fahuoshijian=? ";
			$params = array_merge($params, array('zhibian01,'.$todate, $todate));
		}else if($zhuangtai==5){
			if($old_zhuangtai!=5){
				$jifen = 0;
				$ifhuyuanka = 0;
			}
		}
	}
	$sql.= "WHERE dingdan=? ";
	array_push($params, $dingdan);
	$sta=$pdo->prepare($sql);
	$sta->execute($params);
}
?>
</pre>