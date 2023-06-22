<?php
	session_start();
	session_unset();
	session_destroy();
	setcookie("SESSID", "", time() - 1);

	header("Location: ./login.php");
?>