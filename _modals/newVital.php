<?php
require( '../_modals/database.php' );

$form = $_POST[ 'form' ];
$data = array();

parse_str($form, $data);


$query = $connection->prepare("INSERT INTO vital_sign (patientID, signID, value, time, note)
							VALUES (?, ?, ?, ?, ?)");
$time = $data['date'] . " " . $data['time'] . ":00";
$update = $query->execute(array($data['patientId'], $data['sign'], $data['value'], $time, $data['note'] ));
if($update){
	echo 'OK';
	exit;
}else{
	echo 'Query-Fehler...';
	exit;
}

echo '<strong>Fehler:</strong> ein unbekannter Fehler ist aufgetreten!';