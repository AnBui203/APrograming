<?php 
require_once('connectDB.php');
$Ma_so = $_POST['Ma_so'];
$Dia_chi = $_POST['Dia_chi'];
$Ngay_sinh = $_POST['Ngay_sinh'];
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
if (!$errors){
$query = "EXEC Update_nhan_vien '$Ma_so', '$Dia_chi', '$Ngay_sinh', '$Ma_chi_nhanh', '$SDT', '$Email'";

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