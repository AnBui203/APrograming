<?php 
require_once('connectDB.php');
$Ho_va_ten = $_POST['Ho_va_ten'];
$Ma_so = $_POST['Ma_so'];
$CCCD = $_POST['CCCD'];
$Dia_chi = $_POST['Dia_chi'];
$Ngay_sinh = $_POST['Ngay_sinh'];
$Gioi_tinh = $_POST['Gioi_tinh'];
$Ma_chi_nhanh = $_POST['Ma_chi_nhanh'];
$SDT = $_POST['SDT'];
$Email = $_POST['Email'];
$errors = array();
$conn = OpenCon();

$kt_cn = sqlsrv_query($conn,"SELECT * FROM [dbo].[Chi_nhanh] cn where cn.Ma_chi_nhanh = '$Ma_chi_nhanh'");

if (!sqlsrv_has_rows($kt_cn)) {
    $errors[] = "Chi nhánh không tồn tại";
}
if (!filter_var($Email, FILTER_VALIDATE_EMAIL) && !empty($Email)) {
    $errors[] ="Email không hợp lệ";

}

if (!preg_match("/^0[0-9]{9}$/", $SDT) && !empty($SDT)) {
    $errors[] = "SDT không hợp lệ";
}

if (!preg_match("/^0[0-9]{11}$/", $CCCD) ) {
    $errors[] = "CCCD không hợp lệ";
}

if (!preg_match("/^[0-9]{4}-[0,9]{2}-[0,9]{2}$/", $Ngay_sinh) ) {
    $errors[] = "Ngày sinh không hợp lệ";
}
if(empty($Errors)) {

$query = "EXEC Add_nhan_vien '$Ma_so','$CCCD', '$Dia_chi', '$Ngay_sinh', '$Gioi_tinh', '$Ho_va_ten', '$Ma_chi_nhanh', '$SDT', '$Email'";

$ok = sqlsrv_query($conn,$query);

if ($ok != false) {
    echo "New record created successfully";
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>". $ok ;
    die(print_r(sqlsrv_errors(), true));
}
} else {
    $err = implode(",", $errors);
    header("Location: index.php?err=$err");
}

?>