<?php
require_once('connectDB.php');
$username = $_POST['username'];
$password = $_POST['password'];

if ($username === "admin") {
    echo "New record created successfully";
    header('Location: view');
} else {
    $conn = OpenCon();
    $query = "SELECT * FROM [dbo].[Nhan_vien] WHERE [Ma_so] = '$username' AND [Ma_so] = '$password'";
    $result = sqlsrv_query($conn, $query);
    
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true)); // Print any errors from the query
    }

    if (sqlsrv_has_rows($result)) {
        echo "New record created successfully";
        header('Location: view');
    } else {
        //echo "Error: " . $query . "<br>" . $conn->error;
        $err = "Sai thông tin đăng nhập";
        header('Location: index.php?err=' . $err);
    }
}