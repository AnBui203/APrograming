<?php
    include_once(__DIR__ . '/../connectDB.php');
    $conn = OpenCon();

    $quantities = $_POST['quantity'];
    $barcodes = $_POST['barcode'];
    $id = $_POST['id'];


    if (count($quantities) === count($barcodes)) {
        for ($i = 0; $i < count($quantities); $i++) {
            $quant = $quantities[$i];
            $code = $barcodes[$i];
                    
            $Insertinto = "";
            if ($quant > 0){

                $Insertinto_sp = "INSERT INTO [dbo].[Gom_san_pham] VALUES ('$id', '$code', $quant)";
                $Insertinto_cb = "INSERT INTO [dbo].[Gom_combo] VALUES ('$id', '$code', $quant)"  ;
                $Update_sp = "UPDATE [dbo].[San_pham] SET So_luong = So_luong - $quant WHERE Ma_vach = '$code'"; 

                if(sqlsrv_has_rows(sqlsrv_query($conn,"SELECT * FROM [dbo].[San_pham] WHERE Ma_vach='$code'"))){
                    sqlsrv_query($conn, $Insertinto_sp);
                    sqlsrv_query($conn, $Update_sp);
                }else sqlsrv_query($conn, $Insertinto_cb);
                         
                $quantities[$i] = 0;
                echo $Insertinto;
            }
            
        }
    } else {
        echo "Error: Arrays have different lengths.";
    }
    header('location:edit.php?id='. $id );

    ?>