<?php
session_name("MedInfProjekt");
session_start();

require( 'database.php' );
require( 'passHash.php' );

$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];

$query = $connection->prepare("SELECT staff.* FROM staff, credential WHERE staff.staffID = credential.staffID AND credential.hashed_password LIKE sha(?) AND staff.username=? LIMIT 1;");
$query->execute(array( $password, $username ));

if($query->rowCount() != 1){
	echo 'Login fehlgeschlagen!';
	$connection = null;
	session_write_close();
	die();
}else{
	$row = $query->fetch();
	$_SESSION['username'] = $row[ 'username' ];
	$_SESSION['name'] = $row[ 'name' ];
	$_SESSION['first_name'] = $row[ 'first_name' ];
	$_SESSION['userid'] = $row[ 'staffID' ];
	echo 'OK';
	/*
	$row = $query->fetch();
	if ( PassHash::check_password( $row[ 'password' ], $password ) ) {
		// update last_login
		$updateQuery = $connection->prepare("UPDATE logins SET last_login = NOW()
									WHERE id = ?;");
		$updateQuery->execute(array( $row[ 'id' ]));
		$_SESSION['name'] = $row[ 'name' ];
		$_SESSION['prename'] = $row[ 'prename' ];
		$_SESSION['function'] = $row[ 'function' ];
		$_SESSION['userid'] = $row[ 'id' ];
		echo 'OK';
	}
	else {
		echo 'Login fehlgeschlagen!';
	}
	*/
}
$connection = null;
session_write_close();

