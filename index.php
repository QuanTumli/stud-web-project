<?php
session_name("MedInfProjekt");
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Define some Folders
define('DIR_WEB', dirname(__FILE__));
define('DIR_RESSOURCES', DIR_WEB . '/ressources/');
define('DIR_VIEWS', DIR_WEB . '/_views/');
define('DIR_MODALS', DIR_WEB . '/_modals/');
define('DIR_CONTROLLERS', DIR_WEB . '/_controllers/');

// Define some application details
$app = array();
$app['appname'] = 'Patient';


// Load Twig
require_once(DIR_RESSOURCES . 'Twig-1.15.0/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(DIR_VIEWS);
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());

// check if user is logged in
if (!isset($_SESSION['username']) || isset($_GET['logout'])) {
	include(DIR_CONTROLLERS . 'loginController.php');
}
$app['username'] = $_SESSION['username'];
$app['name'] = $_SESSION['name'];
$app['first_name'] = $_SESSION['first_name'];
$app['userid'] = $_SESSION['userid'];


// form the url
$request = str_replace('/studium/WebApps/project/_mosimann/', '', $_SERVER['REQUEST_URI']); 
$params = preg_split('/[\/]+/', $request);
$safe_pages = array('dashboard', 'patients', 'medicaments'); 
$page = ($params[0] == '')?'dashboard':$params[0];
$par = explode("?", $page);
$page = $par[0];

// include Header and Meta-Data
echo $twig->render('header_header.html', $app);

// include Top-Menu
echo $twig->render('header_topmenu.html', $app);

// include Sidebar-Controller
include(DIR_CONTROLLERS . 'viewController_sidebar.php');

if(in_array($page, $safe_pages)) {
	if(file_exists(DIR_CONTROLLERS . 'viewController_' . $page . '.php')){
		include(DIR_CONTROLLERS . 'viewController_' . $page . '.php');
	}else{
		echo $twig->render('404.html');
	}
}else{
	echo $twig->render('403.html');
}


// include footer
echo $twig->render('footer.html');


//close session
session_write_close();