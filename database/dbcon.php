<?php

// database connection 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_DATABASE', 'retailer');

// try to connect with database 
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

//check connection
if($con===false){
	die('Error: Could not connect. '.mysqli_connect_error());
	exit();
}

