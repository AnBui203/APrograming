<?php
require_once('connectDB.php');
$Ma_so = $_POST['Ma_so'];

$conn = OpenCon();
$query = "CALL Delete_nhan_vien('$Ma_so')";

if ($conn->query($query) === TRUE) {
    echo "Successfully";
    header('Location: index.php');
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
    header('Location: index.php?err=' . $conn->error);
}
?>