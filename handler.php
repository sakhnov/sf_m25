<?php
require 'bootstrap.php';

$method = $_SERVER['REQUEST_METHOD'];

//var_dump(validate($_POST));

if (empty(validate($_POST))) {
	register($_POST);
	header('HTTP/1.1 200');
	header('Content-Type: application/json; charset=UTF-8');
	echo 'success';
} else {

	$error = [
		'errors' => validate($_POST)
	];

	header('HTTP/1.1 500 Internal Server Booboo');
	header('Content-Type: application/json; charset=UTF-8');
	die(json_encode($error, JSON_UNESCAPED_UNICODE));

}

?>