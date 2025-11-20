<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$requesturi = $_SERVER['REQUEST_URI'];
$currenturl = $protocol . $host . $requesturi;
$_SESSION['currenturl'] = $currenturl;
