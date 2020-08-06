<?php
	require_once('../config.php');
	require_once('../connection.php');
	if(isset($_POST['language'])){
		$_SESSION['lang'] = $_POST['language'];
		if(isset($_COOKIE['current-url'])) {
			header("Location:".$_COOKIE['current-url']);
		}
		
	}
?>