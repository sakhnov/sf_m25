<?php
require '../bootstrap.php';

if (!empty($_POST['id'])) {
	deleteComment($_POST['id']);
}
	header('HTTP/1.1 200');
	echo 'success';

?>