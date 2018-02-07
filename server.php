<?php
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($url !== '/' && file_exists(__DIR__.'/public'.$url)) :
    return false;
endif;

$_SERVER['SCRIPT_NAME'] = '/index.php';
require_once __DIR__.'/public/index.php';