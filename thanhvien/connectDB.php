<?php

function OpenCon()
 {
    $dbhost = "BUI-AN-PC\SQLEXPRESS";
    $connection = array("Database"=>"CircleK","UID"=> "buian", "PWD"=>"12345");
    $conn = sqlsrv_connect($dbhost,$connection);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
//else echo 'connection established';


 return $conn;
 }
 
// function CloseCon($conn)
//  {
//  $conn -> close();
//  }

// $conn = OpenCon(); 






?>

