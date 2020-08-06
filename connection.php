<?php

	$_config['host'] = 'localhost';
	$_config['username'] = 'root';
	$_config['password'] = '';
	$_config['dbname'] = 'lalamall';

	// $_config['host'] = 'localhost';
	// $_config['username'] = 'lalamall';
	// $_config['password'] = 'lalamall11235813';
	// $_config['dbname'] = 'lalamall';

	$host = $_config['host'];
	$dbname = $_config['dbname'];
	$user = $_config['username'];
	$pass = $_config['password'];

	$opt = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	try {
		$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, $opt);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	$glb_config['lst_web'] = array();
	if(isset($_SESSION['auth'])){
		$sql = "SELECT id, web_id, web_name FROM g5_web WHERE agency_id = ? AND status = ? ORDER BY web_id ASC";
		$sta=$pdo->prepare($sql);
		$sta->execute(array($_SESSION['auth']->agency_id, 1));
		$lst_web = $sta->fetchAll(PDO::FETCH_OBJ);
		foreach ($lst_web as $key => $value) {
			$glb_config['lst_web'][$value->id] = $value->web_name.' ('.$value->web_id.')';
		}
	}
	
?>