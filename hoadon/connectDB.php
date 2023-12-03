<?php

function OpenCon()
 {
$dbhost = "BUI-AN-PC\SQLEXPRESS";
$connection = array("Database"=>"CircleK","UID"=> "buian", "PWD"=>"12345");
$conn = sqlsrv_connect($dbhost,$connection);


 return $conn;
 }
 
// function CloseCon($conn)
//  {
//  $conn -> close();
//  }

// $conn = OpenCon(); 






?>

