<?php
//Date time
date_default_timezone_set('Asia/Kolkata'); 
$TodayDate = date( 'Y-m-d', time ());

    $user="root"; //username
    $pass="";     //password
    $database_name="task_db";//Database Name
    
$dsn = 'mysql:host=localhost;dbname='.$database_name;

    try{
	     $pdo = new PDO($dsn ,$user , $pass);
	     $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      }catch(PDOException $e){
          die('Error connecting. '. $e->getMessage()); }
