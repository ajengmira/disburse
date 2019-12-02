<?php

function create_db(){
	$host="localhost"; 

	$root="root"; 
	$root_password=""; 

	$user='root';
	$pass='';
	$db="flip"; 

   	$dbh = new PDO("mysql:host=$host", $root, $root_password);

   	$dbh->exec("DROP DATABASE IF EXISTS " . $db);

   	$res = $dbh->exec("CREATE DATABASE `$db`;
            CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
            GRANT ALL ON `$db`.* TO '$user'@'localhost';
            FLUSH PRIVILEGES;");
    
    $dbh = null;
    
    return $res;
}

function create_table(){
	$table = "disburse";

	$db = new PDO("mysql:dbname=flip;host=localhost", "root", "" );
	
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
	
	$sql ="CREATE table $table(
		id int( 11 ) AUTO_INCREMENT PRIMARY KEY,
		amount int( 50 ) NOT NULL, 
		status varchar( 25 ) NOT NULL,
		timestamp datetime NOT NULL, 
		bank_code varchar( 10 ) NOT NULL, 
		account_number int( 50 ) NOT NULL, 
		beneficiary_name varchar( 50 ) NOT NULL,
		remark varchar( 50 ) NOT NULL,
		receipt text DEFAULT NULL,
		time_served datetime NOT NULL,
		fee varchar( 50 ) NOT NULL);" ;

	$res = $db->exec($sql);
	
	$db = null;

	print_r('Create Db & Table Successfully');
	exit();
}

if(create_db()){
	create_table();
}


?>