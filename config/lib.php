<?php


function getPage() { 

	$request = $_SERVER['REQUEST_URI'];
	$request = explode("/",$_SERVER['REQUEST_URI']);

	if (empty($request[2])) {
		switch ($request[1]) {
		    case '/' :
		        return 'pages/home.php';
		        break;
		    case '' :
		        return 'pages/home.php';
		        break;
		    case 'user' :
		        return 'pages/user.php';
		        break;
		    case 'login' :
		        return 'pages/login.php';
		        break;
		    case 'sign' :
		        return 'pages/sign.php';
		        break;
		    case 'photo' :
		        return 'pages/photo.php';
		        break;	 
		    case 'logout' :
		        return 'pages/logout.php';
		        break;		               	        	        
		    default:
		        http_response_code(404);
		        return 'pages/404.php';
		        break;
		}

	} elseif (!empty($request[2]) && $request[1] == 'photo') {
		$photo_id = $request[2];
		if (!empty(getPhoto($photo_id))) {
			//return 'pages/photo.php?id='.$photo_id;
			return 'pages/photo.php/'.$photo_id;
		} else {
	        http_response_code(404);
	        return 'pages/404.php';
		}
	} else {
        http_response_code(404);
        return 'pages/404.php';

	}

}

function get_ip()
{

    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']))
    {
        $ip=$_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    elseif (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;


}



function register(array $data)
{
    $values = [
        $data['name'],
        $data['email'],
        password_hash($data['password'], PASSWORD_ARGON2ID),
        (new DateTime())->format('Y-m-d H:i:s')
    ];
    return insert($values);
}


function addPhoto(array $data)
{
    $values = [
        $data['user_id'],
        $data['filename'],
        (new DateTime())->format('Y-m-d H:i:s')
    ];
    return insertPhoto($values);
}

function addComment(array $data)
{
    $values = [
        $data['user_id'],
        $data['photo_id'],
        $data['comment'],
        (new DateTime())->format('Y-m-d H:i:s')
    ];
    return insertComment($values);
}

function validate(array $request)
{
    $errors = [];
    if (!isset($request['email']) || strlen($request['email']) == 0) {
        $errors[]['email'] = 'Email не указан';
    } elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[]['email'] = 'Неправильный формат email';
    } elseif (strlen($request['email']) < 4) {
        $errors[]['email'] = 'Email должен быть больше 4х символов';
    } elseif (isEmailAlreadyExists($request['email'])) {
        $errors[]['email'] = 'Email уже используется';
    }
    if (!isset($request['name']) || empty($request['name'])) {
        $errors[]['name'] = 'Имя не указано';    }
    if (!isset($request['password']) || empty($request['password'])) {
        $errors[]['password'] = 'Пароль не указан';
    }
    if (!isset($request['repeat-password']) || empty($request['repeat-password'])) {

        $errors[]['repeat-password'] = 'Нужно повторить пароль';

    } elseif ((isset($request['password']) && isset($request['repeat-password'])) && ($request['password'] != $request['repeat-password'])) {

        $errors[]['repeat-password'] = 'Пароли не совпадают';
    }

    return $errors;
}

function isEmailAlreadyExists(string $email)
{
    if (getUserByEmail($email)) {
        return true;
    }
    return false;
}

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}



?>