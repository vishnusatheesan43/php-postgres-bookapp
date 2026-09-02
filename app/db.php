<?php
function getDb() {
    static $db = null;
    if ($db === null) {
        $host = getenv('DB_HOST');
	$dbname = getenv('DB_NAME');
	$user = getenv('DB_USER');
	$pass = getenv('DB_PASS');
        $db = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Create table...
	$db->exec("
	   CREATE TABLE IF NOT EXISTS books 
	( id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
	  title VARCHAR(255) NOT NULL,
	  author VARCHAR(255) NOT NULL,
	  year INT
         )
       ");	
    }
    return $db;
}
