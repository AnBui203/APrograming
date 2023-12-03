<?php 
require_once('connectDB.php');
$Ma_so = $_POST['Ma_so'];
$Dia_chi = $_POST['Dia_chi'];
$Ngay_sinh = $_POST['Ngay_sinh'];
$Ma_chi_nhanh = $_POST['Ma_chi_nhanh'];
$SDT = $_POST['SDT'];
$Email = $_POST['Email'];


$conn = OpenCon();
$query = "CALL Update_nhan_vien('$Ma_so', '$Dia_chi', '$Ngay_sinh', '$Ho_va_ten', '$Ma_chi_nhanh', '$SDT', '$Email' );";
if ($conn->query($query) === TRUE) {
    echo "Successfully";
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
    header('Location: index.php?err=' . $conn->error);
}

?>