<?php
	include 'includes/db.php';
	unset($_SESSION['loginUser']);
	header('Location: singIn.php');
?>