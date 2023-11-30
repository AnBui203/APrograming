<?php

function OpenCon()
 {
$dbhost = "LAPTOP-40PEVMT8";
$connection = array("Database"=>"BTL2","UID"=> "as", "PWD"=>"123");
$conn = sqlsrv_connect($dbhost,$connection);


 return $conn;
 }
 
// function CloseCon($conn)
//  {
//  $conn -> close();
//  }

// $conn = OpenCon(); 






?>

