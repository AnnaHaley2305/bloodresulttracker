<?php

// set up connection parameters
$dbHost 		= 'db709279943.db.1and1.com';
$databaseName 	= 'db709279943';
$username 		= 'dbo709279943';
$password 		= 'BloodResults17!';

// make the database connection
$db = new PDO("mysql:host=$dbHost;dbname=$databaseName;charset=utf8", "$username", "$password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 	// enable error handling
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 			// turn off emulation mode

?>