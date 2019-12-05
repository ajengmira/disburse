<?php

function create_db()
{
    include("config/Database.php");

    $dbh = new PDO("mysql:host=$host", $user, $pass);

    $dbh->exec("DROP DATABASE IF EXISTS " . $db);

    $res = $dbh->exec("CREATE DATABASE `$db`;
            CREATE USER '$user'@'$host' IDENTIFIED BY '$pass';
            GRANT ALL ON `$db`.* TO '$user'@'$host';
            FLUSH PRIVILEGES;");

    $dbh = null;
        
    return $res;
}

function drop_table()
{
    include("config/Database.php");

    $table = "disburse";

    $db1 = new PDO("mysql:dbname=$db;host=$host", "$user", "$pass");
    
    $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Error Handling
    
    $sql ="DROP TABLE IF EXISTS $table" ;

    $res = $db1->exec($sql);

    $db1 = null;
    
    return $res;
}

function create_table()
{
    include("config/Database.php");

    $table = "disburse";

    $db2 = new PDO("mysql:dbname=$db;host=$host", "$user", "$pass");
    
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Error Handling
    
    $sql ="CREATE TABLE $table (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            transaction_id varchar( 100 ) NOT NULL,
            amount int( 50 ) NOT NULL, 
            status varchar( 100 ) NOT NULL,
            timestamp datetime NOT NULL, 
            bank_code varchar( 10 ) NOT NULL, 
            account_number int( 50 ) NOT NULL, 
            beneficiary_name varchar( 50 ) NOT NULL,
            remark varchar( 50 ) NOT NULL,
            receipt text DEFAULT NULL,
            time_served datetime NOT NULL,
            fee varchar( 50 ) NOT NULL,
            created_at datetime DEFAULT NULL,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8" ;

    $res = $db2->exec($sql);
    
    $db2 = null;

    echo 'Create Db & Table Successfully';
    exit();
}

if (create_db()) {
    drop_table();
    create_table();
}
