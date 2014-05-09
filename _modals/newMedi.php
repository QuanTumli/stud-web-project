<?php
require( '../_modals/database.php' );

$form = $_POST[ 'form' ];
$data = array();

parse_str($form, $data);


$query = $connection->prepare("INSERT INTO medicament (medicament_name, unit)
							VALUES (?, ?)");
$update = $query->execute(array($data['name'], $data['unit']));
if($update){
	echo 'OK';
	exit;
}else{
	echo 'Query-Fehler...';
	exit;
}

echo '<strong>Fehler:</strong> ein unbekannter Fehler ist aufgetreten!';