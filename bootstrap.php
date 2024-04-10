<?php session_start();

error_reporting(E_ALL); // Error engine 
ini_set('display_errors', TRUE); // Error display
ini_set('log_errors', TRUE); // Error logging
ini_set('error_log', 'errors.log'); // Logging file 

define('UPLOAD_MAX_SIZE', 1000000); // 1mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', 'uploads');


include 'config/db.php';
include 'config/lib.php';
$page = getPage();