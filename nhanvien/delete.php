<?php
require_once('connectDB.php');
$Ma_so = $_POST['Ma_so'];

$conn = OpenCon();
$query = "EXEC Delete_nhan_vien $Ma_so";

$ok = sqlsrv_query($conn,$query);

if ($ok != false) {
    echo "Successfully";
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>". $ok ;
    die(print_r(sqlsrv_errors(), true));
}
?>