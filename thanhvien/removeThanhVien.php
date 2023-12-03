<?php
require_once('connectDB.php');

$conn = OpenCon();

$maThanhVien = $_GET["maThanhVien"];
//$maThanhVien = substr($maThanhVien, 0, 6);
$CCCD = $_GET["CCCD"];
echo "Ma Thanh Vien: " . $maThanhVien;
echo "CCCD: " . $CCCD;

$query = "DELETE FROM Thanh_vien WHERE Ma_thanh_vien = ? AND CCCD = ?";
$params = array($maThanhVien, $CCCD);
$stmt = sqlsrv_prepare($conn, $query, $params);

if (!$stmt) {
    echo "Lỗi: " . $query . "<br>";
    // print_r(sqlsrv_errors(), true);
} else {
    $result = sqlsrv_execute($stmt);
    if ($result === false) {
        echo "Lỗi: " . $query . "<br>";
        // print_r(sqlsrv_errors(), true);
    } else {
        echo "Xóa thành viên thành công";
        header("Location: toast.html");
        //header("Location: index.php");
    }
}