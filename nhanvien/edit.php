<?php 
require_once('connectDB.php');
$Ma_so = $_POST['Ma_so'];
$Dia_chi = $_POST['Dia_chi'];
$Ngay_sinh = $_POST['Ngay_sinh'];
$Ma_chi_nhanh = $_POST['Ma_chi_nhanh'];
$errors = array();
$conn = OpenCon();

$kt_cn = sqlsrv_query($conn,"SELECT * FROM [dbo].[Chi_nhanh] cn where cn.Ma_chi_nhanh = '$Ma_chi_nhanh'");

if (!sqlsrv_has_rows($kt_cn)) {
    $errors[] = "Chi nhánh không tồn tại";
}

if (!$errors){
$query = "EXEC Update_nhan_vien '$Ma_so', '$Dia_chi', '$Ngay_sinh', '$Ma_chi_nhanh'";

$ok = sqlsrv_query($conn,$query);

if ($ok != false) {
    echo "New record created successfully";
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>". $ok ;
    die(print_r(sqlsrv_errors(), true));
}
}else{
    $err = implode(",", $errors);
    header("Location: index.php?err=$err");
}
?>