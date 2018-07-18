<?php
include "../config.php";

$table   = $prefix . 'settings';
$queryst = $mysqli->query("SELECT email FROM `$table` LIMIT 1");
$rowst   = mysqli_fetch_array($queryst);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>BeFree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../assets/img/favicon.png">
    <meta charset="utf-8">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" media="screen">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
  </head>
  <body>

    <div class="container">