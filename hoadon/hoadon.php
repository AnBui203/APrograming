<?php
    session_start();
    include_once(__DIR__ . '/../connectDB.php');
    $conn = OpenCon();

    $ten_hoa_don = $_POST['Ten_hoa_don'];
    $ma_khach_hang = $_POST['Ma_khach_hang'];
    $ma_nhan_vien = $_POST['Ma_so_nhan_vien_duyet'];
    $ma_chi_nhanh = $_POST['Ma_chi_nhanh'];
    $id = $_POST['So_hoa_don'];
    $ma_giam_gia = $_POST['Ma_giam_gia']; 
    $ma_chuong_trinh = $_POST['Ma_chuong_trinh'];


    $errors = array();
        if (empty($ten_hoa_don)) {
            $errors[]= "Vui lòng nhập tên hóa đơn";
        }
        if (!empty($ten_hoa_don) && strlen($ten_hoa_don) > 255) {
            $errors[]= "Tên hóa đơn không được vượt quá 255 ký tự";
        }
        if (empty($ma_nhan_vien)) {
                $errors[] = "Vui lòng nhập mã nhân viên tạo đơn";
        }else{
            $querymaso = "SELECT * FROM [dbo].[Nhan_vien] WHERE Ma_so = ?";
            $paramsnv = array($ma_nhan_vien);
            $resultnv = sqlsrv_query($conn, $querymaso, $paramsnv);
            if (!sqlsrv_has_rows($resultnv)) {
                $errors[] = "Nhân viên không tồn tại";
            }
        }
        if (empty($ma_chi_nhanh)) {
                $errors[] = "Vui lòng nhập mã chi nhánh";
        }else{
            $querymacn = "SELECT * FROM [dbo].[Chi_nhanh] cn where cn.Ma_chi_nhanh = ?";
            $paramscn = array($ma_chi_nhanh);
            $resultcn = sqlsrv_query($conn, $querymacn, $paramscn);
            if (!sqlsrv_has_rows($resultcn)) {
                $errors[] = "Chi nhánh không tồn tại";
            }
        }
        if (empty($ma_giam_gia)) {
            $ma_giam_gia = NULL;
        }
        if (empty($ma_chuong_trinh)) {
            $ma_chuong_trinh = 'NULL';
        }
        if (empty($ma_khach_hang)) {
            $ma_khach_hang = 0;
        }elseif(!empty($ma_khach_hang)){
            $result_ma_kh = sqlsrv_query($conn,"SELECT* FROM [dbo].[Khach_hang] WHERE Ma_khach_hang = $ma_khach_hang");
            if (!sqlsrv_has_rows($result_ma_kh)) {
                $errors[] = "Khách hàng đã vanish";
            }
        }elseif (!empty($ma_giam_gia)) {
            $result_ma_gg = sqlsrv_query($conn,"SELECT * FROM [dbo].[Phieu_giam_gia] pg JOIN [dbo].Thanh_vien tv
                                                ON pg.Ma_thanh_vien = tv.Ma_thanh_vien
                                                WHERE Ma_giam_gia = $ma_giam_gia AND Ma_khach_hang = $ma_khach_hang");
            if (!sqlsrv_has_rows($result_ma_gg)) {
                $errors[] = "Mã giảm giá không tồn tại cho khách hàng này";
            }
        }
         if ($errors) {
            //  $_SESSION['error'] = $errors;
            //  header('Location: edit.php?id=' . $id);
            //  exit();
            foreach ($errors as $error) {
                echo '<div>' . htmlspecialchars($error) . '</div>';
            }

            }
    $check_kh = "SELECT * FROM [dbo].[Khach_hang] WHERE Ma_khach_hang = '$ma_khach_hang'";
    $Insert_kh =" INSERT INTO [dbo].[Khach_hang] VALUES ('$ma_khach_hang')";
    

    $exist_kh = sqlsrv_query($conn, $check_kh);
    if (!sqlsrv_has_rows($exist_kh)){
        $insert_error =sqlsrv_query($conn, $Insert_kh);
        if ($insert_error === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }elseif ($exist_kh === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $update_error = $updatehoadon = "EXEC Cap_nhat_hd '$ten_hoa_don', '$ma_khach_hang', '$ma_nhan_vien', '$ma_chi_nhanh', '$id',". ($ma_giam_gia ? $ma_giam_gia:'NULL') .",". ($ma_chuong_trinh ? $ma_chuong_trinh:'NULL');
    echo($updatehoadon);
    sqlsrv_query($conn, $updatehoadon);
    if ($update_error === false) {
        die(print_r(sqlsrv_errors(), true));
    }
 

    sqlsrv_close($conn);
    header('location:edit.php?id='. $id );
    
?>
