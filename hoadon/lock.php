<?php
include_once(__DIR__ . '/../connectDB.php');
$conn = OpenCon();

$id = $_POST['So_hoa_don'];
$date = date('Y-m-d');
echo $id;
echo $date;
sqlsrv_query($conn,"UPDATE [dbo].[Hoa_don] SET Thoi_gian_xuat = '$date' WHERE So_hoa_don = '$id'" );
header('location:edit.php?id='. $id );
?>