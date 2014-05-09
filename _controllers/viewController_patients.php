<?php
require( DIR_MODALS . 'database.php' );



if(isset($_GET["id"])){
	if(intval($_GET["id"])){
		/* show details for a specific patient */
		$id = $_GET["id"];
		
		$query = $connection->prepare("SELECT * FROM patient WHERE patientID = ? LIMIT 1;");
		$query->execute(array($id));
		$patient = $query->fetch();
		
		$query = $connection->prepare("SELECT * FROM vital_sign v 
								INNER JOIN patient p ON v.patientID = p.patientID
								INNER JOIN sign s ON v.signID = s.signID
								WHERE p.patientID = ?
								ORDER BY v.time ASC;");
		$query->execute(array($id));
		$vitalSigns = $query->fetchAll();
		
		$query = $connection->prepare("SELECT m.time, med.medicament_name, med.unit, m.quantity, s.name AS pfeger_name, s.first_name AS pfeger_vorname, s2.name AS arzt_name, s2.first_name AS arzt_vorname 
								FROM medicine m
								INNER JOIN patient p ON m.patientID = p.patientID
								INNER JOIN staff s ON m.staffID_nurse = s.staffID
								INNER JOIN staff s2 ON m.staffID_physician = s2.staffID
								INNER JOIN medicament med ON med.medicamentID = m.medicamentID
								WHERE m.patientID = ?
								ORDER BY m.time ASC;");
		$query->execute(array($id));
		$medicaments = $query->fetchAll();
		
		$query = $connection->prepare("SELECT * FROM medicament
									ORDER BY medicament_name ASC;");
		$query->execute();
		$allMedis = $query->fetchAll();
		
		$query = $connection->prepare("SELECT * FROM sign
									ORDER BY sign_name ASC;");
		$query->execute();
		$allSigns = $query->fetchAll();
		
		$query = $connection->prepare("SELECT * FROM staff s
									INNER JOIN function f ON s.fonctionID = f.functionID
									WHERE f.function_name = ?
									ORDER BY s.name ASC;");
		$query->execute(array('Nurse'));
		$allNurses = $query->fetchAll();
		
		$query = $connection->prepare("SELECT * FROM staff s
									INNER JOIN function f ON s.fonctionID = f.functionID
									WHERE f.function_name = ?
									ORDER BY s.name ASC;");
		$query->execute(array('Physician'));
		$allPhysicians = $query->fetchAll();
		
		
		$data['patient'] = $patient;
		$data['vitalSigns'] = $vitalSigns;
		$data['medicaments'] = $medicaments;
		$data['allMedis'] = $allMedis;
		$data['allSigns'] = $allSigns;
		$data['allNurses'] = $allNurses;
		$data['allPhysicians'] = $allPhysicians;
		
		echo $twig->render('patients_details.html', $data);
		return;
	}
}else{
	/* show patient list */
	$query = $connection->prepare("SELECT * FROM patient");
	$query->execute();
	$results = $query->fetchAll();
	
	$data['results'] = $results;
	
	echo $twig->render('patients.html', $data);
	
}