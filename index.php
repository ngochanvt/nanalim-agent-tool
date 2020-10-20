<?php
	require_once('config.php');
	require_once('connection.php');
	require_once('common/header.php');
?>

<?php
	if($glb_config['route']!='auth-login'){
		if(!isset($_SESSION['auth'])) echo "<script>window.location='".$glb_config['baseurl']."index.php?route=auth-login'</script>";
		else{
			require_once('common/menu_left.php');
		}
	}else{
		if(isset($_SESSION['auth'])) echo "<script>window.location='".$glb_config['baseurl']."index.php?route=home'</script>";
	}
	
	if($glb_config['route']!='auth-login'){
		if(!in_array($glb_config['route'], $glb_config['accept_route'])){
			echo "<script>window.location='".$glb_config['baseurl']."index.php?route=home'</script>";
		}
	}
	
	switch ($glb_config['route']) {
		case 'auth-login':
			require_once('view/v_auth_login.php');
			break;
		case 'web-order-overview':
			require_once('view/v_web_order_overview.php');
			break;
		case 'order-list':
			require_once('view/v_order_list.php');
			break;
		case 'payment-list':
			require_once('view/v_payment_list.php');
			break;
		case 'web-order':
			require_once('view/v_web_order.php');
			break;
		case 'web-overview':
			require_once('view/v_web_overview.php');
			break;
		case 'web-detail':
			require_once('view/v_web_detail.php');
			break;
		case 'home':
			require_once('view/v_web_overview.php');
			break;
		case 'profile':
			require_once('view/v_profile.php');
			break;
		case 'logout':
			unset($_SESSION['auth']);
			echo "<script>location.reload();</script>";
			break;
		default:
			# code...
			break;
	}
?>
	
<?php
	require_once('common/footer.php');
?>