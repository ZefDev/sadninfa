<?php

require_once 'config.php';

$connection = mysqli_connect($config['db']['server'], $config['db']['username'], $config['db']['password'], 
	$config['db']['name']);

if($connection == false){
	echo mysqli_error(link);
	exit();
}
$connection->set_charset("utf8");
session_start();
// закрываем подключение
?>