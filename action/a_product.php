<pre>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	require_once('../config.php');
	require_once('../connection.php');
	// require_once('../php_ftp.php');
	if(isset($_POST['create-order'])){

		$sql="SELECT COUNT(shopname) as mingci FROM shop_zhibian";
		$sta = $pdo->prepare($sql);
		$sta->execute(array());
		$mingci = $sta->fetch(PDO::FETCH_OBJ)->mingci;

		$inserted_ids=array();
		$shjiaids = $glb_config['lst_shjiaid'];
		// $ftp = new ftp();
		// $ftp->conn('211.149.249.111', 'Administrator', 'huqm2h84');

		$images=array();
		$shoppic = '';
		if(isset($_FILES['shoppic'])){
		  	if($_FILES['shoppic']['error']==0){
		        $shoppic='uploadpic/'.$_FILES["shoppic"]["name"];
				//$ftp->put('/'.$shoppic, $_FILES['shoppic']['tmp_name']);
				move_uploaded_file ( $_FILES['shoppic']['tmp_name'] ,"../../".$shoppic);
		  	}
		}
		$zhuang = '';
		if(isset($_FILES['zhuang'])){
		  	if($_FILES['zhuang']['error']==0){
		  		$zhuang='uploadpic/'.$_FILES["zhuang"]["name"];
				//$ftp->put('/'.$zhuang, $_FILES['zhuang']['tmp_name']);
				move_uploaded_file ( $_FILES['zhuang']['tmp_name'] ,"../../".$zhuang);
		  	}
		}
		if(isset($_FILES['product-images'])){
			$len = count($_FILES['product-images']['name'])>4?4:count($_FILES['product-images']['name']);
			for($i=0; $i<$len; $i++){
				if($_FILES['product-images']['error'][$i]==0 && $_FILES['product-images']['name'][$i]!=''){
					$images[$i] = 'uploadpic/'.$_FILES['product-images']['name'][$i];
					//$ftp->put('/'.$images[$i], $_FILES['product-images']['tmp_name'][$i]);
					move_uploaded_file ( $_FILES['product-images']['tmp_name'][$i] ,"../../".$images[$i]);
				}
				
			}
		}
		/*Data*/
		$mch = 'name';
		$color = NULL;
		$size1 = NULL;
		$xuni = NULL;
		$auto = NULL;
		$type = NULL;
		$type1 = NULL;
		$type2 = NULL;
		$guojia = $_POST['guojia'];
		$pinpainew = $_POST['pinpainew'];
		$pp = 'brand';
		$cj = 'origin';
		$cjname = $_POST['cjname'];
		$isbn1 = 'specification';
		$jj = 'unit';
		$jg = 'price';
		$zl = 'inventory';
		$tp = 'image';
		$nr = 'content';
		$tc = 'pop-up';
		$px = 'sort';
		$ljzy = 'Links to transfer';
		$sftc = $_POST['sftc'];
		$lj = isset($_POST['lj'])&& !empty($_POST['lj'])?$_POST['lj']:'www';
		$sx = $_POST['sx'];
		$xianshi = null;
		$zhibianid = 0;
		$shangji = null;
		$zliangm = 'weight';
		$zliang = $_POST['zliang']; 
		$zliangdw = '千克'; 
		$anclassid = isset($_POST['anclassid'])&&!empty($_POST['anclassid'])?$_POST['anclassid']:'';
		$nclassid = isset($_POST['nclassid'])&&!empty($_POST['nclassid'])?$_POST['nclassid']:'';
		$xclassid = isset($_POST['xclassid'])&&!empty($_POST['xclassid'])?$_POST['xclassid']:'';
		$shopname = $_POST['shopname'];
		$pinpai = $_POST['pinpai'];
		$isbn = 'specification';
		$shopchuban = $_POST['shopchuban'];
		$shichangjia = $_POST['shichangjia'];
		$huiyuanjia = $_POST['huiyuanjia'];
		$vipjia = $_POST['vipjia'];
		$pifajia = $_POST['pifajia'];
		$dazhe = $_POST['hyj'];
		$kucun = $_POST['kucun'];
		$gj ='keyword';
		$gjz = $_POST['gjz'];
		$shoppic = $shoppic;
		$zhuang = $zhuang;
		$shopzz = null;
		$p1 = $images[0];
		$p2 = $images[1];
		$p3 = $images[2];
		$p4 = $images[3];
		$shopcontent = $_POST['shopcontent'];
		$banci = 0;
		$yeshu = $_POST['yeshu'];
		$bestshop = isset($_POST['bestshop'])&&!empty($_POST['bestshop'])?1:0;
		$jinkouxianhuo = isset($_POST['jinkouxianhuo'])&&!empty($_POST['jinkouxianhuo'])?1:0;
		$newsshop = isset($_POST['newsshop'])&&!empty($_POST['newsshop'])?1:0;
		$tejiashop = isset($_POST['tejiashop'])&&!empty($_POST['tejiashop'])?1:0;
		$cxiaoshop = isset($_POST['cxiaoshop'])&&!empty($_POST['cxiaoshop'])?1:0;
		$meiritejia = isset($_POST['meiritejia'])&&!empty($_POST['meiritejia'])?1:0;
		$huodongzhuanqu = isset($_POST['huodongzhuanqu'])&&!empty($_POST['huodongzhuanqu'])?1:0;
		$vip = 0;
		$gonghuo = isset($_POST['gonghuo'])&&!empty($_POST['gonghuo'])?$_POST['gonghuo']:'';
		$gongyingshang = '';
		$chengjiaocount = $_POST['chengjiaocount'];
		$liulancount = 0;
		$adddate = date('Y-m-d H:i:s.v');
		$pingji = 0;
		$pingjizong = 0;
		$ps = '배송 지역';
		$dq1 = isset($_POST['dq1'])&&!empty($_POST['dq1'])?$_POST['dq1']:0;
		$dq2 = isset($_POST['dq2'])&&!empty($_POST['dq2'])?$_POST['dq2']:0;
		$dq3 = isset($_POST['dq3'])&&!empty($_POST['dq3'])?$_POST['dq3']:0;
		$dq4 = isset($_POST['dq4'])&&!empty($_POST['dq4'])?$_POST['dq4']:0;
		$dq = $dq1.','.$dq2.','.$dq3.','.$dq4;
		$psdq1 = isset($_POST['psdq1'])&&!empty($_POST['psdq1'])?$_POST['psdq1']:'';
		$psdq2 = isset($_POST['psdq2'])&&!empty($_POST['psdq2'])?$_POST['psdq2']:'';
		$psdq3 = isset($_POST['psdq3'])&&!empty($_POST['psdq3'])?$_POST['psdq3']:'';
		$psdq4 = isset($_POST['psdq4'])&&!empty($_POST['psdq4'])?$_POST['psdq4']:'';
		$psdq = $psdq1.','.$psdq2.','.$psdq3.','.$psdq4;
		$shopdate = null;
		$dinge = '||';
		$x1 = 'date';
		$x2 = 'Bar code';
		$x3 = 'rate';
		$x4 = 'postage instructions';
		$x5 = 'carton size';
		$x6 = 'MOQ';
		$y1 = $_POST['year'].'年'.$_POST['month'].'月';
		$y2 = $_POST['y2'];
		$y3 = $_POST['y3'];
		$y4 = $_POST['y4'];
		$y5 = $_POST['y5'];
		$y6 = $_POST['y6'];
		$mingci1 = $mingci;
		$mingci2 = $mingci;
		$mingci3 = $mingci;
		$mingci4 = $mingci;
		$mingcidate = date('Y-m-d H:i:s.v');
		$shenhe = 1;
		$duihuan = 0;
		$duijiejia = $vipjia;
		$duihuanjia = 0;
		$chengbenjia = 0;
		$guanfangshenhe = 1;
		$cangwei_id = $_POST['cangwei_id'];
		$baoyou = isset($_POST['baoyou'])&&!empty($_POST['baoyou'])?$_POST['baoyou']:0;
		$baoyou_man = $_POST['baoyou_man'];
		$mansong = isset($_POST['mansong'])&&!empty($_POST['mansong'])?$_POST['mansong']:0;;
		$mansong_man = $_POST['mansong_man'];
		$mansong_song = $_POST['mansong_song'];
		$manjian = isset($_POST['manjian'])&&!empty($_POST['manjian'])?$_POST['manjian']:0;;
		$manjian_man = $_POST['manjian_man'];
		$manjian_jian = $_POST['manjian_jian'];
		$b1 = $_POST['b1'];
		$b2 = $_POST['b2'];
		$b3 = $_POST['b3'];
		try{
		$pdo->beginTransaction();

		$sql="INSERT INTO shop_zhibian (";
			$sql.="mch,";
			$sql.="pp,";
			$sql.="jj,";
			$sql.="jg,";
			$sql.="zl,";
			$sql.="isbn1,";
			$sql.="tp,";
			$sql.="nr,";
			$sql.="tc,";
			$sql.="px,";
			$sql.="ljzy,";
			$sql.="cj,";
			$sql.="cjname,";
			$sql.="gj,";
			$sql.="shopname,";
			$sql.="pinpai,";
			$sql.="shopchuban,";
			$sql.="yeshu,";
			$sql.="banci,";
			$sql.="shoppic,";
			$sql.="p1,";
			$sql.="p2,";
			$sql.="p3,";
			$sql.="p4,";
			$sql.="isbn,";
			$sql.="shopcontent,";
			$sql.="pingji,";
			$sql.="shichangjia,";
			$sql.="huiyuanjia,";
			$sql.="vipjia,";
			$sql.="pifajia,";
			$sql.="gjz,";
			$sql.="bestshop,";
			$sql.="tejiashop,";
			$sql.="cxiaoshop,";
			$sql.="newsshop,";
			$sql.="kucun,";
			$sql.="chengjiaocount,";
			$sql.="liulancount,";
			$sql.="dazhe,";
			$sql.="nclassid,";
			$sql.="anclassid,";
			$sql.="zhuang,";
			$sql.="shopzz,";
			$sql.="adddate,";
			$sql.="pingjizong,";
			$sql.="sx,";
			$sql.="lj,";
			$sql.="sftc,";
			$sql.="ps,";
			$sql.="dq,";
			$sql.="psdq,";
			$sql.="shopdate,";
			$sql.="x1,";
			$sql.="x2,";
			$sql.="x3,";
			$sql.="x4,";
			$sql.="x5,";
			$sql.="x6,";
			$sql.="y1,";
			$sql.="y2,";
			$sql.="y3,";
			$sql.="y4,";
			$sql.="y5,";
			$sql.="y6,";
			$sql.="vip,";
			$sql.="xclassid,";
			$sql.="mingci1,";
			$sql.="mingci2,";
			$sql.="mingci3,";
			$sql.="mingci4,";
			$sql.="mingcidate,";
			$sql.="zliangm,";
			$sql.="zliang,";
			$sql.="zliangdw,";
			$sql.="dinge,";
			$sql.="shjiaid,";
			$sql.="shjianame,";
			$sql.="xianshi,";
			$sql.="zhibianid,";
			$sql.="shangji,";
			$sql.="duijiejia,";
			$sql.="b1,";
			$sql.="b2,";
			$sql.="b3,";
			$sql.="duihuan,";
			$sql.="shenhe,";
			$sql.="duihuanjia,";
			$sql.="jinkouxianhuo,";
			$sql.="chengbenjia,";
			$sql.="guanfangshenhe,";
			$sql.="gonghuo,";
			$sql.="gongyingshang,";
			$sql.="guojia,";
			$sql.="pinpainew,";
			$sql.="meiritejia,";
			$sql.="huodongzhuanqu,";
			$sql.="cangwei_id,";
			$sql.="baoyou,";
			$sql.="baoyou_man,";
			$sql.="mansong,";
			$sql.="mansong_man,";
			$sql.="mansong_song,";
			$sql.="type,";
			$sql.="color,";
			$sql.="size1,";
			$sql.="xuni,";
			$sql.="auto,";
			$sql.="manjian,";
			$sql.="manjian_man,";
			$sql.="manjian_jian,";
			$sql.="type1,";
			$sql.="type2 )";
			$sql.=" VALUES";
			$sql.="(";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?,";
			$sql.="?)";
		
		$sta=$pdo->prepare($sql);
		foreach($shjiaids as $shjiaid => $username){
			$gongyingshang = $username;
			$array_params=array(
				$mch,
				$pp,
				$jj,
				$jg,
				$zl,
				$isbn1,
				$tp,
				$nr,
				$tc,
				$px,
				$ljzy,
				$cj,
				$cjname,
				$gj,
				$shopname,
				$pinpai,
				$shopchuban,
				$yeshu,
				$banci,
				$shoppic,
				$p1,
				$p2,
				$p3,
				$p4,
				$isbn,
				$shopcontent,
				$pingji,
				$shichangjia,
				$huiyuanjia,
				$vipjia,
				$pifajia,
				$gjz,
				$bestshop,
				$tejiashop,
				$cxiaoshop,
				$newsshop,
				$kucun,
				$chengjiaocount,
				$liulancount,
				$dazhe,
				$nclassid,
				$anclassid,
				$zhuang,
				$shopzz,
				$adddate,
				$pingjizong,
				$sx,
				$lj,
				$sftc,
				$ps,
				$dq,
				$psdq,
				$shopdate,
				$x1,
				$x2,
				$x3,
				$x4,
				$x5,
				$x6,
				$y1,
				$y2,
				$y3,
				$y4,
				$y5,
				$y6,
				$vip,
				$xclassid,
				$mingci1,
				$mingci2,
				$mingci3,
				$mingci4,
				$mingcidate,
				$zliangm,
				$zliang,
				$zliangdw,
				$dinge,
				$shjiaid,
				$gongyingshang,
				$xianshi,
				$zhibianid,
				$shangji,
				$duijiejia,
				$b1,
				$b2,
				$b3,
				$duihuan,
				$shenhe,
				$duihuanjia,
				$jinkouxianhuo,
				$chengbenjia,
				$guanfangshenhe,
				$gonghuo,
				$gongyingshang,
				$guojia,
				$pinpainew,
				$meiritejia,
				$huodongzhuanqu,
				$cangwei_id,
				$baoyou,
				$baoyou_man,
				$mansong,
				$mansong_man,
				$mansong_song,
				$type,
				$color,
				$size1,
				$xuni,
				$auto,
				$manjian,
				$manjian_man,
				$manjian_jian,
				$type1,
				$type2
			);
			$sta->execute($array_params);
			$inserted_ids[$shjiaid] = $pdo->lastInsertId();
		}
		$pdo->commit();
	}
	catch(Exception $e){
	    //An exception has occured, which means that one of our database queries
	    //failed.
	    //Print out the error message.
	    echo $e->getMessage();
	    //Rollback the transaction.
	    $pdo->rollBack();
	}

	try{
		$pdo->beginTransaction();
		$sql = "INSERT INTO ref_product_shjiaid (id_gen, shopid, shjiaid) VALUES(?, ?, ?)";
		$sta=$pdo->prepare($sql);
		$id_gen = date('U');
		foreach($inserted_ids as $k=>$v){
			$sta->execute(array($id_gen, intval($v), $k));
		}
		$pdo->commit();
	}
	catch(Exception $e){
	    //An exception has occured, which means that one of our database queries
	    //failed.
	    //Print out the error message.
	    echo $e->getMessage();
	    //Rollback the transaction.
	    $pdo->rollBack();
	}
		//var_dump($inserted_ids);
		
	header('Location: '.$glb_config['baseurl'].'index.php?route=product-add');
	}
	if(isset($_POST['update-order'])){
		$shopid=$_POST['shopid'];

		$sql = "SELECT * FROM shop_zhibian where shopid = ?";
		$sta=$pdo->prepare($sql);
		$sta->execute(array($shopid));
		$current_product = $sta->fetch(PDO::FETCH_OBJ);

		$ftp = new ftp();
		$ftp->conn('211.149.249.111', 'Administrator', 'huqm2h84');
		$shoppic = $current_product->shoppic;

		$deleted_shoppic=$_POST['deleted_shoppic'];
		if($deleted_shoppic==1){
			if(isset($_FILES['shoppic'])){
			  	if($_FILES['shoppic']['error']==0 && $_FILES["shoppic"]["name"]!=''){
			        $shoppic='uploadpic/'.md5($_FILES["shoppic"]["name"]).'.'.pathinfo($_FILES["shoppic"]["name"], PATHINFO_EXTENSION);
					// $ftp->put('/'.$shoppic, $_FILES['shoppic']['tmp_name']);
					move_uploaded_file ( $_FILES['shoppic']['tmp_name'] ,"../../".$shoppic);
			  	}
			}else{
				$shoppic = '';
			}
		}
		
		$zhuang = $current_product->zhuang;

		$deleted_zhuang=$_POST['deleted_zhuang'];
		if($deleted_zhuang==1){
			if(isset($_FILES['zhuang'])){
			  	if($_FILES['zhuang']['error']==0 && $_FILES["zhuang"]["name"]!=''){
			  		$zhuang='uploadpic/'.md5($_FILES["zhuang"]["name"]).'.'.pathinfo($_FILES["zhuang"]["name"], PATHINFO_EXTENSION);
					// $ftp->put('/'.$zhuang, $_FILES['zhuang']['tmp_name']);
					move_uploaded_file ( $_FILES['zhuang']['tmp_name'] ,"../../".$zhuang);
			  	}
			}else{
				$zhuang = "";
			}
		}
		
		$images = array($current_product->p1, $current_product->p2, $current_product->p3, $current_product->p4);
		$deleted_old_image = $_POST['deleted_old_image'];
		var_dump($deleted_old_image);
		$deleted_old_image = explode(',', $deleted_old_image);
		var_dump($deleted_old_image);
		$max_image=0;
		foreach ($deleted_old_image as $key => $value) {
			$images[$key] = '';
			$max_image++;
		}
		var_dump($images);
		// die();
		if(isset($_FILES['product-images'])){
			$len = count($_FILES['product-images']['name'])>$max_image?$max_image:count($_FILES['product-images']['name']);
			for($i=0; $i<$len; $i++){
				if($_FILES['product-images']['error'][$i]==0 && $_FILES['product-images']['name'][$i]!=''){
					foreach ($images as $key => $value) {
						if($value=='') {
							$images[$key] = 'uploadpic/'.md5($_FILES['product-images']['name'][$i]).'.'.pathinfo($_FILES['product-images']['name'][$i], PATHINFO_EXTENSION);
							// $ftp->put('/'.$images[$key], $_FILES['product-images']['tmp_name'][$i]);
							move_uploaded_file ( $_FILES['product-images']['tmp_name'][$i] ,"../../".$images[$key]);
							break;
						}
					}
				}
			}
		}
		var_dump($images);
		/*Data*/
		$mch = 'name';
		$color = NULL;
		$size1 = NULL;
		$xuni = NULL;
		$auto = NULL;
		$type = NULL;
		$type1 = NULL;
		$type2 = NULL;
		$guojia = $_POST['guojia'];
		$pinpainew = $_POST['pinpainew'];
		$pp = 'brand';
		$cj = 'origin';
		$cjname = $_POST['cjname'];
		$isbn1 = 'specification';
		$jj = 'unit';
		$jg = 'price';
		$zl = 'inventory';
		$tp = 'image';
		$nr = 'content';
		$tc = 'pop-up';
		$px = 'sort';
		$ljzy = 'Links to transfer';
		$sftc = $_POST['sftc'];
		$lj = isset($_POST['lj'])&& !empty($_POST['lj'])?$_POST['lj']:'www';
		$sx = $_POST['sx'];
		$xianshi = null;
		$zhibianid = 0;
		$shangji = null;
		$zliangm = 'weight';
		$zliang = $_POST['zliang']; 
		$zliangdw = '千克'; 
		$anclassid = isset($_POST['anclassid'])&&!empty($_POST['anclassid'])?$_POST['anclassid']:'';
		$nclassid = isset($_POST['nclassid'])&&!empty($_POST['nclassid'])?$_POST['nclassid']:'';
		$xclassid = isset($_POST['xclassid'])&&!empty($_POST['xclassid'])?$_POST['xclassid']:'';
		$shopname = $_POST['shopname'];
		$pinpai = $_POST['pinpai'];
		$isbn = 'specification';
		$shopchuban = $_POST['shopchuban'];
		$shichangjia = $_POST['shichangjia'];
		$huiyuanjia = $_POST['huiyuanjia'];
		$vipjia = $_POST['vipjia'];
		$pifajia = $_POST['pifajia'];
		$dazhe = $_POST['hyj'];
		$kucun = $_POST['kucun'];
		$gj ='keyword';
		$gjz = $_POST['gjz'];
		$shoppic = $shoppic;
		$zhuang = $zhuang;
		$shopzz = null;
		$p1 = $images[0];
		$p2 = $images[1];
		$p3 = $images[2];
		$p4 = $images[3];
		$shopcontent = $_POST['shopcontent'];
		$banci = 0;
		$yeshu = $_POST['yeshu'];
		$bestshop = isset($_POST['bestshop'])&&!empty($_POST['bestshop'])?1:0;
		$jinkouxianhuo = isset($_POST['jinkouxianhuo'])&&!empty($_POST['jinkouxianhuo'])?1:0;
		$newsshop = isset($_POST['newsshop'])&&!empty($_POST['newsshop'])?1:0;
		$tejiashop = isset($_POST['tejiashop'])&&!empty($_POST['tejiashop'])?1:0;
		$cxiaoshop = isset($_POST['cxiaoshop'])&&!empty($_POST['cxiaoshop'])?1:0;
		$meiritejia = isset($_POST['meiritejia'])&&!empty($_POST['meiritejia'])?1:0;
		$huodongzhuanqu = isset($_POST['huodongzhuanqu'])&&!empty($_POST['huodongzhuanqu'])?1:0;
		$vip = 0;
		$gonghuo = isset($_POST['gonghuo'])&&!empty($_POST['gonghuo'])?$_POST['gonghuo']:'';
		// $gongyingshang = '';
		$chengjiaocount = $_POST['chengjiaocount'];
		$liulancount = 0;
		// $adddate = date('Y-m-d H:i:s.v');
		$pingji = 0;
		$pingjizong = 0;
		$ps = '배송 지역';
		$dq1 = isset($_POST['dq1'])&&!empty($_POST['dq1'])?$_POST['dq1']:0;
		$dq2 = isset($_POST['dq2'])&&!empty($_POST['dq2'])?$_POST['dq2']:0;
		$dq3 = isset($_POST['dq3'])&&!empty($_POST['dq3'])?$_POST['dq3']:0;
		$dq4 = isset($_POST['dq4'])&&!empty($_POST['dq4'])?$_POST['dq4']:0;
		$dq = $dq1.','.$dq2.','.$dq3.','.$dq4;
		$psdq1 = isset($_POST['psdq1'])&&!empty($_POST['psdq1'])?$_POST['psdq1']:'';
		$psdq2 = isset($_POST['psdq2'])&&!empty($_POST['psdq2'])?$_POST['psdq2']:'';
		$psdq3 = isset($_POST['psdq3'])&&!empty($_POST['psdq3'])?$_POST['psdq3']:'';
		$psdq4 = isset($_POST['psdq4'])&&!empty($_POST['psdq4'])?$_POST['psdq4']:'';
		$psdq = $psdq1.','.$psdq2.','.$psdq3.','.$psdq4;
		$dinge = '||';
		$x1 = 'date';
		$x2 = 'Bar code';
		$x3 = 'rate';
		$x4 = 'postage instructions';
		$x5 = 'carton size';
		$x6 = 'MOQ';
		$y1 = $_POST['year'].'年'.$_POST['month'].'月';
		$y2 = $_POST['y2'];
		$y3 = $_POST['y3'];
		$y4 = $_POST['y4'];
		$y5 = $_POST['y5'];
		$y6 = $_POST['y6'];
		// $mingci1 = $current_product->mingci;
		// $mingci2 = $current_product->mingci;
		// $mingci3 = $current_product->mingci;
		// $mingci4 = $current_product->mingci;
		// $mingcidate = date('Y-m-d H:i:s.v');
		$shenhe = 1;
		$duihuan = 0;
		$duijiejia = $vipjia;
		$duihuanjia = 0;
		$chengbenjia = 0;
		$guanfangshenhe = 1;
		$cangwei_id = $_POST['cangwei_id'];
		$baoyou = isset($_POST['baoyou'])&&!empty($_POST['baoyou'])?$_POST['baoyou']:0;
		$baoyou_man = $_POST['baoyou_man'];
		$mansong = isset($_POST['mansong'])&&!empty($_POST['mansong'])?$_POST['mansong']:0;;
		$mansong_man = $_POST['mansong_man'];
		$mansong_song = $_POST['mansong_song'];
		$manjian = isset($_POST['manjian'])&&!empty($_POST['manjian'])?$_POST['manjian']:0;;
		$manjian_man = $_POST['manjian_man'];
		$manjian_jian = $_POST['manjian_jian'];
		$b1 = $_POST['b1'];
		$b2 = $_POST['b2'];
		$b3 = $_POST['b3'];

		$sql="SELECT shopid FROM ref_product_shjiaid WHERE id_gen = (SELECT id_gen FROM ref_product_shjiaid WHERE shopid = ? )";
		$sta=$pdo->prepare($sql);
		$sta->execute(array($shopid));
		$ref_shopid=$sta->fetchAll(PDO::FETCH_OBJ);
		$lst_shopid=array();
		if($ref_shopid!=null && count($ref_shopid)>0){
			foreach ($ref_shopid as $key => $value) {
				array_push($lst_shopid, $value->shopid);
			}
		}else{
			array_push($lst_shopid, $shopid);
		}
		// var_dump($lst_shopid);
		$sql = "UPDATE shop_zhibian SET ";
		$sql.="mch = ?,";
			$sql.="pp = ?,";
			$sql.="jj = ?,";
			$sql.="jg = ?,";
			$sql.="zl = ?,";
			$sql.="isbn1 = ?,";
			$sql.="tp = ?,";
			$sql.="nr = ?,";
			$sql.="tc = ?,";
			$sql.="px = ?,";
			$sql.="ljzy = ?,";
			$sql.="cj = ?,";
			$sql.="cjname = ?,";
			$sql.="gj = ?,";
			$sql.="shopname = ?,";
			$sql.="pinpai = ?,";
			$sql.="shopchuban = ?,";
			$sql.="yeshu = ?,";
			$sql.="banci = ?,";
			$sql.="shoppic = ?,";
			$sql.="p1 = ?,";
			$sql.="p2 = ?,";
			$sql.="p3 = ?,";
			$sql.="p4 = ?,";
			$sql.="isbn = ?,";
			$sql.="shopcontent = ?,";
			$sql.="pingji = ?,";
			$sql.="shichangjia = ?,";
			$sql.="huiyuanjia = ?,";
			$sql.="vipjia = ?,";
			$sql.="pifajia = ?,";
			$sql.="gjz = ?,";
			$sql.="bestshop = ?,";
			$sql.="tejiashop = ?,";
			$sql.="cxiaoshop = ?,";
			$sql.="newsshop = ?,";
			$sql.="kucun = ?,";
			$sql.="chengjiaocount = ?,";
			$sql.="liulancount = ?,";
			$sql.="dazhe = ?,";
			$sql.="nclassid = ?,";
			$sql.="anclassid = ?,";
			$sql.="zhuang = ?,";
			$sql.="shopzz = ?,";
			// $sql.="adddate = ?,";
			$sql.="pingjizong = ?,";
			$sql.="sx = ?,";
			$sql.="lj = ?,";
			$sql.="sftc = ?,";
			$sql.="ps = ?,";
			$sql.="dq = ?,";
			$sql.="psdq = ?,";
			$sql.="x1 = ?,";
			$sql.="x2 = ?,";
			$sql.="x3 = ?,";
			$sql.="x4 = ?,";
			$sql.="x5 = ?,";
			$sql.="x6 = ?,";
			$sql.="y1 = ?,";
			$sql.="y2 = ?,";
			$sql.="y3 = ?,";
			$sql.="y4 = ?,";
			$sql.="y5 = ?,";
			$sql.="y6 = ?,";
			$sql.="vip = ?,";
			$sql.="xclassid = ?,";
			// $sql.="mingci1 = ?,";
			// $sql.="mingci2 = ?,";
			// $sql.="mingci3 = ?,";
			// $sql.="mingci4 = ?,";
			// $sql.="mingcidate = ?,";
			$sql.="zliangm = ?,";
			$sql.="zliang = ?,";
			$sql.="zliangdw = ?,";
			$sql.="dinge = ?,";
			// $sql.="shjiaid = ?,";
			// $sql.="shjianame = ?,";
			$sql.="xianshi = ?,";
			$sql.="zhibianid = ?,";
			$sql.="shangji = ?,";
			$sql.="duijiejia = ?,";
			$sql.="b1 = ?,";
			$sql.="b2 = ?,";
			$sql.="b3 = ?,";
			$sql.="duihuan = ?,";
			$sql.="shenhe = ?,";
			$sql.="duihuanjia = ?,";
			$sql.="jinkouxianhuo = ?,";
			$sql.="chengbenjia = ?,";
			$sql.="guanfangshenhe = ?,";
			$sql.="gonghuo = ?,";
			// $sql.="gongyingshang = ?,";
			$sql.="guojia = ?,";
			$sql.="pinpainew = ?,";
			$sql.="meiritejia = ?,";
			$sql.="huodongzhuanqu = ?,";
			$sql.="cangwei_id = ?,";
			$sql.="baoyou = ?,";
			$sql.="baoyou_man = ?,";
			$sql.="mansong = ?,";
			$sql.="mansong_man = ?,";
			$sql.="mansong_song = ?,";
			$sql.="type = ?,";
			$sql.="color = ?,";
			$sql.="size1 = ?,";
			$sql.="xuni = ?,";
			$sql.="auto = ?,";
			$sql.="manjian = ?,";
			$sql.="manjian_man = ?,";
			$sql.="manjian_jian = ?,";
			$sql.="type1 = ?,";
			$sql.="type2 = ? ";
		$sql.= " WHERE shopid IN ";
		$k = array_fill(0, count($lst_shopid), '?');
  		$k = " ( ".implode(',', $k).' ) ';
  		$sql.=$k;
		$sta=$pdo->prepare($sql);
		$array_params=array(
					$mch,
					$pp,
					$jj,
					$jg,
					$zl,
					$isbn1,
					$tp,
					$nr,
					$tc,
					$px,
					$ljzy,
					$cj,
					$cjname,
					$gj,
					$shopname,
					$pinpai,
					$shopchuban,
					$yeshu,
					$banci,
					$shoppic,
					$p1,
					$p2,
					$p3,
					$p4,
					$isbn,
					$shopcontent,
					$pingji,
					$shichangjia,
					$huiyuanjia,
					$vipjia,
					$pifajia,
					$gjz,
					$bestshop,
					$tejiashop,
					$cxiaoshop,
					$newsshop,
					$kucun,
					$chengjiaocount,
					$liulancount,
					$dazhe,
					$nclassid,
					$anclassid,
					$zhuang,
					$shopzz,
					// $adddate,
					$pingjizong,
					$sx,
					$lj,
					$sftc,
					$ps,
					$dq,
					$psdq,
					$x1,
					$x2,
					$x3,
					$x4,
					$x5,
					$x6,
					$y1,
					$y2,
					$y3,
					$y4,
					$y5,
					$y6,
					$vip,
					$xclassid,
					// $mingci1,
					// $mingci2,
					// $mingci3,
					// $mingci4,
					// $mingcidate,
					$zliangm,
					$zliang,
					$zliangdw,
					$dinge,
					// $shjiaid,
					// $gongyingshang,
					$xianshi,
					$zhibianid,
					$shangji,
					$duijiejia,
					$b1,
					$b2,
					$b3,
					$duihuan,
					$shenhe,
					$duihuanjia,
					$jinkouxianhuo,
					$chengbenjia,
					$guanfangshenhe,
					$gonghuo,
					// $gongyingshang,
					$guojia,
					$pinpainew,
					$meiritejia,
					$huodongzhuanqu,
					$cangwei_id,
					$baoyou,
					$baoyou_man,
					$mansong,
					$mansong_man,
					$mansong_song,
					$type,
					$color,
					$size1,
					$xuni,
					$auto,
					$manjian,
					$manjian_man,
					$manjian_jian,
					$type1,
					$type2
				);
		$array_params = array_merge($array_params, $lst_shopid);
		$sta->execute($array_params);
		header('Location: '.$glb_config['baseurl'].'index.php?route=product-edit&shopid='.$shopid);
	}
?>
</pre>