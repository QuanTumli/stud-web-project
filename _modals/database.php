<?php

$dbHost = 'localhost';
$dbName = 'studium_medinf_projekt';
$dbUser = 'medinf_projekt';
$dbPassword = 'aMlk901#';

try {
	$connection = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPassword);
	$connection->exec("SET NAMES utf8");
} catch ( Exception $e ) {
	
	// TODO: do some error-handling
	die();
}