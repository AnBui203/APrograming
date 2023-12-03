<?php
require_once('connectDB.php');

if (isset($_POST["submit"])) {
    $maThanhVien = $_POST['maThanhVien'];
    $cccd = $_POST['cccd'];
    $hoVaTen = $_POST['hoVaTen'];
    $gioiTinh = $_POST['gioiTinh'];
    $diemTichLuy = $_POST['diemTichLuy'];
    $maKhachHang = $_POST['maKhachHang'];

    $conn = OpenCon();

    //Check if CCCD or Ma_thanh_vien exists in Thanh_vien table
    $queryCheck = "SELECT CCCD, Ma_thanh_vien FROM Thanh_vien WHERE CCCD = ? OR Ma_thanh_vien = ?";
    $paramsCheck = array($cccd, $maThanhVien);
    $stmtCheck = sqlsrv_query($conn, $queryCheck, $paramsCheck);
    // Still check but only for Toast Display
    $queryThanhVienCheck = "SELECT Ma_thanh_vien FROM Thanh_vien WHERE Ma_thanh_vien = ?";
    $paramsThanhVienCheck = array($maThanhVien);
    $stmtThanhVienCheck = sqlsrv_query($conn, $queryThanhVienCheck, $paramsThanhVienCheck);
    
    $queryCCCDCheck = "SELECT CCCD FROM Thanh_vien WHERE CCCD = ?";
    $paramsCCCDCheck = array($cccd);
    $stmtCCCDCheck = sqlsrv_query($conn, $queryCCCDCheck, $paramsCCCDCheck);

    // Check if maKhachHang already exists in Khach_hang table
    $queryKhachHangCheck = "SELECT Ma_khach_hang FROM Khach_hang WHERE Ma_khach_hang = ?";
    $paramsKhachHangCheck = array($maKhachHang);
    $stmtKhachHangCheck = sqlsrv_query($conn, $queryKhachHangCheck, $paramsKhachHangCheck);

    $maThanhVienExists = false;
    $cccdExists = false;
    $maKhachHangExists = false;

   //  while ($row = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC)) {
   //      if ($row['CCCD'] === $cccd) {
   //          $cccdExists = true;
   //          break;
   //      }

   //      if ($row['Ma_thanh_vien'] === $maThanhVien) {
   //          $maThanhVienExists = true;
   //          break;
   //      }
   //  }

    // Check if maThanhVien exists
    if (sqlsrv_has_rows($stmtThanhVienCheck)) {
      $maThanhVienExists = true;
  }   

    // Check if CCCD exists
    if (sqlsrv_has_rows($stmtCCCDCheck)) {
      $cccdExists = true;
  }     

    // Check if maKhachHang exists
    if (sqlsrv_has_rows($stmtKhachHangCheck)) {
        $maKhachHangExists = true;
    }

    // If Ma_thanh_vien, CCCD , or maKhachHang exists, show the corresponding toast message
    if ($maThanhVienExists || $cccdExists || $maKhachHangExists) {
        if ($maThanhVienExists) {
            echo "<script>alert('Trùng dữ liệu hệ thống: Mã thành viên đã tồn tại');</script>";
        }

        if ($cccdExists) {
         echo "<script>alert('Trùng dữ liệu hệ thống: CCCD đã tồn tại');</script>";
     }

        if ($maKhachHangExists) {
            echo "<script>alert('Trùng dữ liệu hệ thống: Mã khách hàng đã tồn tại');</script>";
        }
    } else {
      if ($diemTichLuy >= 0) {
         // If CCCD and Ma_thanh_vien do not exist, proceed with the insertion
         if (!sqlsrv_has_rows($stmtCheck)) {
             // Insert into Khach_hang table
             $query = "INSERT INTO Khach_hang (Ma_khach_hang) VALUES (?)";
             $params = array($maKhachHang);
             $stmt = sqlsrv_query($conn, $query, $params);
     
             //Insert into Thanh_vien table
             if ($stmt) {
                 $query2 = "INSERT INTO Thanh_vien (Ma_thanh_vien, CCCD, Ho_va_ten, Gioi_tinh, Diem_tich_luy, Ma_khach_hang)
                            VALUES (?, ?, ?, ?, ?, ?)";
                 $params2 = array($maThanhVien, $cccd, $hoVaTen, $gioiTinh, $diemTichLuy, $maKhachHang);
                 $stmt2 = sqlsrv_query($conn, $query2, $params2);
     
                 if ($stmt2) {
                     header("Location: index.php?msg=Thêm thành viên thành công");
                 } else {
                     echo "Loi: " . print_r(sqlsrv_errors(), true);
                 }
             } else {
                 echo "Loi: " . print_r(sqlsrv_errors(), true);
             }
         }
     } else {
         echo "<script>alert('Điểm tích lũy không thể là một số âm');</script>";
       }
      }
   }      
?>



<!DOCTYPE html>
<html lang="en">

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

<body>
   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
      <a href="index.php">CircleK by Night Stalker - Quản lý thành viên</a>
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Thêm thành viên mới</h3>
         <p class="text-muted">Hoàn thành biểu mẫu dưới đây để thêm thành viên mới</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Mã thành viên:</label>
                  <input type="text" class="form-control" name="maThanhVien" placeholder="Mã thành viên">
               </div>

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

            <div class="mb-3">
               <label class="form-label">Mã khách hàng:</label>
               <input type="text" class="form-control" name="maKhachHang" placeholder="Mã khách hàng">
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