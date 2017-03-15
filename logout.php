<?php
	ini_set("session.save_path", "/home/unn_w13029619/sessionData");
	session_start();

	$_SESSION = array();

	session_unset();

	session_destroy();

	header('Location: index.php');

?>