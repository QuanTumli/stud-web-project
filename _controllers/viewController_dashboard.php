<?php

require( DIR_MODALS . 'database.php' );

$query = $connection->prepare("SELECT * FROM patient");
$query->execute();
$count = $query->rowCount();

$query = $connection->prepare("SELECT * FROM patient WHERE gender = ?");
$query->execute(array(1));
$maleCount = $query->rowCount();
$query->execute(array(2));
$femaleCount = $query->rowCount();

$query = $connection->prepare("SELECT * FROM vital_sign v 
								INNER JOIN patient p ON v.patientID = p.patientID
								INNER JOIN sign s ON v.signID = s.signID
								ORDER BY v.time DESC
								LIMIT 5;");
$query->execute();
$vitalSigns = $query->fetchAll();

$query = $connection->prepare("SELECT m.time, med.medicament_name, med.unit, m.quantity, s.name AS pfeger_name, s.first_name AS pfeger_vorname, p.first_name AS vorname, p.name AS name, p.patientID
								FROM medicine m
								INNER JOIN patient p ON m.patientID = p.patientID
								INNER JOIN staff s ON m.staffID_nurse = s.staffID
								INNER JOIN staff s2 ON m.staffID_physician = s2.staffID
								INNER JOIN medicament med ON med.medicamentID = m.medicamentID
								ORDER BY m.time DESC
								LIMIT 5;");
$query->execute();
$medicaments = $query->fetchAll();




$data['vitalSigns'] = $vitalSigns;
$data['medicaments'] = $medicaments;

$data['user']['firstname'] = $_SESSION['first_name'];
$data['user']['name'] = $_SESSION['name'];
$data['patients']['count'] = $count;
$data['patients']['male'] = $maleCount;
$data['patients']['female'] = $femaleCount;


echo $twig->render('dashboard.html', $data);