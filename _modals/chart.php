<?php
header('Content-Type: application/json');
require( '../_modals/database.php' );
$chartType = $_GET["type"];
$id = $_GET["id"];

switch($chartType){
	case "temp":
		$type = "Temperature";
		break;
	case "puls":
		$type = "Pulse";
		break;
	case "blutdruck":
		$type = "Blood pressure";
		break;
}

$query = $connection->prepare("SELECT UNIX_TIMESTAMP(v.time)*1000 AS time, v.value AS value FROM vital_sign v 
								INNER JOIN patient p ON v.patientID = p.patientID
								INNER JOIN sign s ON v.signID = s.signID
								WHERE p.patientID = ?
									AND s.sign_name = ?
								ORDER BY v.time ASC;");
							
$query->execute(array($id, $type));
$vitalSigns = $query->fetchAll();

if(count($vitalSigns) == 0){
	$jsonArray[] = array();
}else{
	foreach ( $vitalSigns as $row ){
	    $jsonArray[] = array( intval($row['time']), doubleval($row['value']) );
	}
}
$json = array( 
    "label" => $type,
    "data" => $jsonArray
);

echo json_encode( $json );
?>