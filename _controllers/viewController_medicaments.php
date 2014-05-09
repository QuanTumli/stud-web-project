<?php
require( DIR_MODALS . 'database.php' );

$query = $connection->prepare("SELECT * FROM medicament
								ORDER BY medicament_name ASC;");
$query->execute();
$allMedis = $query->fetchAll();

$data['results'] = $allMedis;

echo $twig->render('medicaments.html', $data);