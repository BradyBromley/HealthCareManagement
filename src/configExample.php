<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'USER');
define('DB_PASSWORD', 'PASS');
define('DB_NAME', 'HealthCareManagement');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_errno) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

?>