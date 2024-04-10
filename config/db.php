<?php
/**

 * @return PDO

 */

function get_connection()
{
    return new PDO('mysql:host=127.0.0.1;dbname=sf_m25', 'root', 'root');
}

function insert(array $data)
{
    $query = 'INSERT INTO users (name, email, password, created_at) VALUES(?, ?, ?, ?)';
    $db = get_connection();
    $stmt = $db->prepare($query);
    return $stmt->execute($data);
}

function getUserByEmail(string $email)
{
    $query = 'SELECT * FROM users WHERE email = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result;
    }
    return false;
}

function getUserById($id)
{
    $query = 'SELECT * FROM users WHERE id = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function updateUserHash($id, $hash, $user_ip)
{
    $query = 'UPDATE users SET hash = :hash, user_ip = :user_ip WHERE id = :id';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute(array('id' => $id, 'hash' => $hash, 'user_ip' => $user_ip));
}


function getUsersList()
{
    $query = 'SELECT * FROM users ORDER BY id DESC';
    $db = get_connection();
    return $db->query($query,PDO::FETCH_ASSOC);
}

function getUserPhotos($user_id)
{
    $query = 'SELECT * FROM photos WHERE user_id = '.$user_id.' ORDER BY created_at DESC';
    $db = get_connection();
    return $db->query($query,PDO::FETCH_ASSOC);
}

function getPhoto($photo_id)
{
    $query = 'SELECT * FROM photos WHERE id = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$photo_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    //return $db->query($query,PDO::FETCH_ASSOC);
}


function getAllPhotos()
{
    $query = 'SELECT * FROM photos ORDER BY created_at DESC';
    $db = get_connection();
    return $db->query($query,PDO::FETCH_ASSOC);
}

function deletePhoto($id)
{
    $query = 'DELETE FROM comments WHERE photo_id = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $stmt->fetch(PDO::FETCH_ASSOC);

    $query = 'DELETE FROM photos WHERE id = ?';
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $stmt->fetch(PDO::FETCH_ASSOC);

}


function getAllComments($photo_id)
{
    $query = 'SELECT * FROM comments WHERE photo_id = ? ORDER BY created_at DESC';
    //$query = 'SELECT * FROM comments ORDER BY created_at DESC';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$photo_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteComment($id)
{
    $query = 'DELETE FROM comments WHERE id = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function checkUser() {
    if (empty($_COOKIE['id'])) return false;

    $query = 'SELECT * FROM users WHERE id = ? LIMIT 1';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$_COOKIE['id']]);    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!empty($result)):
        if(($result['hash'] !== $_COOKIE['hash']) or ($result['id'] !== $_COOKIE['id'])
     or (($result['user_ip'] !== $_SERVER['REMOTE_ADDR']) and ($result['user_ip'] !== "0")))
        {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
            return false;
        }
        else
        {
            return array('id' => $result['id'], 'name' => $result['name']);
        }
    endif;
}

function insertPhoto(array $data) {
    $query = 'INSERT INTO photos (user_id, filename, created_at) VALUES(?, ?, ?)';
    $db = get_connection();
    $stmt = $db->prepare($query);
    return $stmt->execute($data);
}

function insertComment(array $data) {
    $query = 'INSERT INTO comments (user_id, photo_id, comment, created_at) VALUES(?, ?, ?, ?)';
    $db = get_connection();
    $stmt = $db->prepare($query);
    return $stmt->execute($data);
}