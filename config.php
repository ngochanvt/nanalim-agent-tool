<?php
	session_start();
	ini_set('max_execution_time', '0');
	error_reporting(E_ERROR | E_PARSE);
	date_default_timezone_set('Asia/Seoul');
	$glb_config=array();
	$glb_config['baseurl'] 	= 'http://localhost/nanalim/agency/';
	// $glb_config['baseurl'] 	= 'https://nanalim-shop.com.vn/agency/';
	$glb_config['lang']  	= isset($_SESSION['lang'])?$_SESSION['lang']:'kr';
	$glb_config['route'] 	= isset($_GET['route'])?$_GET['route']:'home';
	$glb_config['current_role'] = 0;
	// $lang = file_get_contents($glb_config['baseurl'].'config/language.json');
	// var_dump($lang);
	
?>

<?php
	if(isset($_SESSION['auth'])){
		$_SESSION['auth']->role = trim($_SESSION['auth']->role);
		$glb_config['accept_role'] = array(0, 1, 2, 3);
		$glb_config['accept_route'] = ['auth-login', 'home', 'web-order-overview', 'web-detail', 'order-list', 'web-order', 'payment-list', 'order-detail', 'logout', 'web-overview', 'web-detail'];
		// switch ($_SESSION['auth']->role){
		// 	case 'manager':
		// 		$glb_config['accept_role'] = array(0, 1, 3, 2);
		// 		$glb_config['accept_route'] = ['auth-login', 'home', 'product-add', 'product-list', 'orders', 'logout', 'product-edit', 'order-detail'];
		// 		break;
		// 	case 'lalamall':
		// 		$glb_config['accept_role'] = array(0, 1, 3, 4);
		// 		$glb_config['accept_route'] = ['auth-login', 'home', 'product-add', 'product-list', 'orders-lalamall', 'logout', 'product-edit', 'order-detail-lalamall'];
		// 		break;
		// }
		switch ($glb_config['route']) {
			case 'auth-login':
				break;
			case 'home':
				break;
			case 'web-list':
			case 'web-order':
				$glb_config['current_role'] = 0;
				break;
			case 'web-detail':
				$glb_config['current_role'] = 0;
				break;
			case 'order-list':
				$glb_config['current_role'] = 1;
				break;
			case 'payment-list':
				$glb_config['current_role'] = 1;
				break;
			case 'order-detail':
				$glb_config['current_role'] = 1;
				break;
			case 'logout':
				$glb_config['current_role'] = 3;
				break;
			default:
				# code...
				break;
		}
	}

?>

<?php
function khongdau($str) {
	global $glb_config;
	$lang=$glb_config['lang'];
	if ($lang=='vn') {
		$str = strtolower($str);
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'a', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'e', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'i', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'o', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'u', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'y', $str);
		$str = preg_replace("/(Đ)/", 'd', $str);
		$str = preg_replace('/[^A-Za-z0-9\-]/', '-', $str);
		$str = preg_replace('/(--)/', '', $str);
		$str = str_replace(" ", '', $str );
	}else{
		$str = preg_replace("/[^[:alnum:][:space:]]/u", '-', $str);
		$str = preg_replace('/(--)/', '', $str);
		$str = str_replace(" ", '', $str );
	}
	
	return $str;
}
function trigger_send_mail($email_to, $name_to, $subject, $content){
	$mail = new PHPMailer();
	$mail->IsSMTP();             
	$mail->CharSet  = "utf-8";
	$mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;    // enable SMTP authentication
	$mail->SMTPSecure = "ssl";   // sets the prefix to the servier
	$mail->Host       = 'smtp.gmail.com';
	$mail->Port       = 465;  
	  

	$mail->Username   = 'zunik.web.contact@gmail.com';  // khai bao dia chi email
	$mail->Password   = 'han11235813';            // khai bao mat khau
	$mail->SetFrom('zunik.web.contact@gmail.com', 'Zunik.vn');
	$mail->AddReplyTo('zunik.web.contact@gmail.com', 'Zunik.vn'); //khi nguoi dung phan hoi se duoc gui den email nay
	//$mail->AddCC('dat.nguyen@zunik.vn');
	$mail->Subject    = $subject;// tieu de email 
	
	$mail->MsgHTML($content);// noi dung chinh cua mail se nam o day.
	$mail->AddAddress($email_to, $name_to);
	return $mail->Send();
}
function change_meta_tags($title,$description,$keywords){
        // This function made by Jamil Hammash
    $output = ob_get_contents();
    if ( ob_get_length() > 0) { ob_end_clean(); }
    $patterns = array("/<title>(.*?)<\/title>/","<meta name='description' content='(.*)'>","<meta name='keywords' content='(.*)'>");
    $replacements = array("<title>$title</title>","meta name='description' content='$description'","meta name='keywords' content='$keywords'");

    $output = preg_replace($patterns, $replacements,$output);  
    echo $output;
}
$lang = file_get_contents($glb_config['baseurl'].'config/language.json');

$lang = (array)json_decode($lang, true);

$cur_lang = $lang[$glb_config['lang']];
?>