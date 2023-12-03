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


$conn = OpenCon();
$query = "CALL Add_nhan_vien('$Ma_so', '$Dia_chi', '$Ngay_sinh', '$Ma_chi_nhanh', '$SDT', '$Email');";

if ($conn->query($query) === TRUE) {
    echo "New record created successfully";
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
    header('Location: index.php?err=' . $conn->error);
}

?>