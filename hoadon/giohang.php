<?php
include_once(__DIR__ . '/../connectDB.php');
$conn = OpenCon();

    $so_luong = $_POST['so_luong'];
    $ma_vach = $_POST['ma_vach'];
    $id = $_POST['id'];

    if (count($so_luong) === count($ma_vach)) {
        for ($i = 0; $i < count($ma_vach); $i++) {
            $quant = $so_luong[$i];
            $code = $ma_vach[$i];
                     
            $Update = "";
            if ($quant >= 0){
                $Update_sp = "UPDATE Gom_san_pham SET So_luong = $quant WHERE Ma_vach = '$code' AND So_hoa_don = '$id'";
                $Update_cb = "UPDATE Gom_combo SET So_luong = $quant WHERE Ma_combo = '$code' AND So_hoa_don = '$id'";
                $so_luong[$i] = 0;
            }
               sqlsrv_query($conn, $Update_sp);
               sqlsrv_query($conn, $Update_cb);
        }
    } else {
        echo "Error: Arrays have different lengths.";
    }

       sqlsrv_close($conn);
//echo $Update_sp;
    header('location:edit.php?id='. $id );

?>