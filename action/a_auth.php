<?php
	require_once('../config.php');
	require_once('../connection.php');
	if(isset($_POST['login'])){
		$sql = "SELECT * FROM g5_agency WHERE username = ? AND password = ? AND status = ?";
		$sta=$pdo->prepare($sql);
		$sta->execute(array($_POST['username'], md5($_POST['password']), 1));
		$result = $sta->fetch(PDO::FETCH_OBJ);
		if(isset($result->username)){
			$_SESSION['auth'] = $result;
		}else{
			echo "<script>alert('Thông tin đăng nhập không chính xác, vui lòng kiểm tra lại')</script>";
		}
		header('Location:'.$glb_config['baseurl'].'index.php?route=home');
		
	}
?>