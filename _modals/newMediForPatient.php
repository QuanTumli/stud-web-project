<?php
require( '../_modals/database.php' );

$form = $_POST[ 'form' ];
$data = array();

parse_str($form, $data);


$query = $connection->prepare("INSERT INTO medicine (patientID, staffID_nurse, staffID_physician, medicamentID, quantity, time, note)
							VALUES (?, ?, ?, ?, ?, ?, ?)");
$time = $data['date'] . " " . $data['time'] . ":00";
$update = $query->execute(array($data['patientId'], $data['nurse'], $data['physician'], $data['medicament'], $data['quantity'], $time, $data['note'] ));
if($update){
	echo 'OK';
	exit;
}else{
	echo 'Query-Fehler...';
	exit;
}

echo '<strong>Fehler:</strong> ein unbekannter Fehler ist aufgetreten!';