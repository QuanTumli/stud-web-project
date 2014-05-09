<?php
if(isset($_GET['logout'])){
	session_destroy();
	session_write_close();
	header("Location: ./");
	exit;
}else{
	echo $twig->render('login.html', $app);
	session_write_close();
	exit;
}