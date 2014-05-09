<?php
require( DIR_MODALS . 'database.php' );

$query = $connection->prepare("SELECT * FROM patient");
$query->execute();
$patientCount = $query->rowCount();
$query = $connection->prepare("SELECT * FROM staff");
$query->execute();
$staffCount = $query->rowCount();

$data['patients']['count'] = $patientCount;
$data['staff']['count'] = $staffCount;

echo $twig->render('header_sidebar.html', $data);