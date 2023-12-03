<?php
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__ . '/../connectDB.php');
$conn = OpenCon();
// 2. Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$id = $_POST[''];

$sql = "DELETE FROM [dbo].[Hoa_don] WHERE So_hoa_don=$id;";

// 3. Thực thi câu lệnh DELETE
    $result = sqlsrv_query($conn, $sql);

// 4. Đóng kết nối
    sqlsrv_close($conn);

// Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');