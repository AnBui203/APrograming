<?php
require_once('connectDB.php');

$maThanhVien = $_GET['maThanhVien'];
if (isset($_POST["submit"])) {
    $cccd = $_POST['cccd'];
    $hoVaTen = $_POST['hoVaTen'];
    $gioiTinh = $_POST['gioiTinh'];
    $diemTichLuy = $_POST['diemTichLuy'];

    $conn = OpenCon();

    // Check if the CCCD already exists in the Thanh_vien table
    $queryCheckCCCD = "SELECT * FROM Thanh_vien WHERE CCCD = ?";
    $paramsCheckCCCD = array($cccd);
    $stmtCheckCCCD = sqlsrv_query($conn, $queryCheckCCCD, $paramsCheckCCCD);

    if (sqlsrv_has_rows($stmtCheckCCCD)) {
        //echo "CCCD đã bị trùng, vui lòng nhập lại.";
        echo "<script>alert('CCCD đã bị trùng trong dữ liệu hệ thống, vui lòng nhập lại!');</script>";
    } else {
        // Get the existing values for the member
        $queryGetMember = "SELECT * FROM Thanh_vien WHERE Ma_thanh_vien = ?";
        $paramsGetMember = array($maThanhVien);
        $stmtGetMember = sqlsrv_query($conn, $queryGetMember, $paramsGetMember);
        $row = sqlsrv_fetch_array($stmtGetMember, SQLSRV_FETCH_ASSOC);

        // Keep the existing values if the corresponding field is empty
        $cccd = empty($cccd) ? $row['CCCD'] : $cccd;
        $hoVaTen = empty($hoVaTen) ? $row['Ho_va_ten'] : $hoVaTen;
        $gioiTinh = empty($gioiTinh) ? $row['Gioi_tinh'] : $gioiTinh;
        $diemTichLuy = empty($diemTichLuy) ? $row['Diem_tich_luy'] : $diemTichLuy;
        $maKhachHang = $row['Ma_khach_hang'];
        if($diemTichLuy >= 0){
            // Update Thanh_vien table
            $queryUpdate = "UPDATE Thanh_vien SET CCCD = ?, Ho_va_ten = ?, Gioi_tinh = ?, Diem_tich_luy = ? WHERE Ma_thanh_vien = ?";
            $paramsUpdate = array($cccd, $hoVaTen, $gioiTinh, $diemTichLuy, $maThanhVien);
            $stmtUpdate = sqlsrv_query($conn, $queryUpdate, $paramsUpdate);

            if ($stmtUpdate) {
            header("Location: index.php?msg=Cập nhật thông tin thành viên thành công");
            exit;
            } else {
                echo "Error: " . print_r(sqlsrv_errors(), true);
            }
        } 
        else{echo "<script>alert('Điểm tích lũy không thể là một số âm');</script>";
      }   
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống chuỗi cửa hàng OrvalK</title>

    <!-- Liên kết CSS Bootstrap bằng CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            text-align: left;
            width: 100%;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: left;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: blue;
        }
    </style>

    <!-- Liên kết CSS Bootstrap bằng CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<div class="navbar left-align">
    <a href="../view/index.php">Home</a>
    <a href="../hoadon">Hóa đơn</a>
    <a href="../nhanvien/">Nhân Viên</a>
    <a href="../thanhvien">Thành Viên</a>
    <!-- Add more navigation links as needed -->
</div>
<body>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>Bootstrap demo</title>
</head>
<br/>
<body>
   
   <div class="container">
      <div class="text-center mb-4">
         <h3>Sửa đổi thông tin thành viên</h3>
         <p class="text-muted mt-2">Hoàn thành biểu mẫu dưới đây để thay đổi thông tin thành viên</p>
         <h4 class="text-xs text-muted">Đối với thông tin không cần chỉnh sửa, hãy để trống</h4>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="row mb-3">

               <div class="col">
                  <label class="form-label">CCCD:</label>
                  <input type="text" class="form-control" name="cccd" placeholder="CCCD">
               </div>
            </div>

            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Họ và tên:</label>
                  <input type="text" class="form-control" name="hoVaTen" placeholder="Họ và tên">
               </div>

               <div class="col">
                  <label class="form-label">Giới tính:</label>
                  <select class="form-select" name="gioiTinh">
                     <option value="">Chọn giới tính</option>
                     <option value="Nam">Nam</option>
                     <option value="Nu">Nữ</option>
                  </select>
               </div>
            </div>

            <div class="mb-3">
               <label class="form-label">Điểm tích lũy:</label>
               <input type="number" class="form-control" name="diemTichLuy" placeholder="Điểm tích lũy">
            </div>

            <div>
               <button type="submit" class="btn btn-success" name="submit">Lưu</button>
               <a href="index.php" class="btn btn-danger">Hủy bỏ</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>