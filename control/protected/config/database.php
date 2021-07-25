<?php

// This is the database connection configuration.
return array(
	// 'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

	'connectionString' => 'mysql:host=bom-db;dbname=controlbom',
	'emulatePrepare' => true,
	'username' => 'appuser',
	'password' => 'appuserPasswd',
	'charset' => 'utf8',
);
