<?php
// Load central config
require_once __DIR__ . '/../../config.php';

$site = SITE_URL;
$targetFolder = UPLOAD_FOLDER;

try {
 $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS,
array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $exception){
 error_log("DB Connection Error: " . $exception->getMessage());
 die("A database error occurred. Please try again later.");
}
?>