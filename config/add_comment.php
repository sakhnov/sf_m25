<?php
require '../bootstrap.php';

if (!empty($_POST['comments'])): 
	addComment(['user_id' => $_POST['user_id'], 'photo_id' => $_POST['photo_id'], 'comment' => $_POST['comments']]);
endif; 

	header("Location: /photo/".$_POST['photo_id']); exit; 

?>