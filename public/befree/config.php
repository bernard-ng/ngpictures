<?php
$host     = "127.1.1.1"; // Database Host
$user     = "root"; // Database Username
$password = ""; // Database's user Password
$database = "security_ngbd"; // Database Name
$prefix   = "security_"; // Database Prefix for the script tables

$mysqli = new mysqli($host, $user, $password, $database);

// Checking Connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$mysqli->set_charset("utf8");

$site_url             = "http://127.1.1.1";
$projectsecurity_path = "http://127.1.1.1/befree";
?>