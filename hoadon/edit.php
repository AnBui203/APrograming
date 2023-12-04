<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống chuỗi cửa hàng OrvalK</title>
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
    <a href="./index.php">Hóa đơn</a>
    <a href="../nhanvien/">Nhân Viên</a>
    <a href="../thanhvien">Thành Viên</a>
    <!-- Add more navigation links as needed -->
</div>
    <?php
    session_start();
    $id = urldecode($_GET['id']);
    
    // Truy vấn database
    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once(__DIR__ . '/../connectDB.php');
    $conn = OpenCon();

    // 2. Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
    // Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
    
    $sqlSelect = "SELECT * FROM [dbo].[Hoa_don] WHERE So_hoa_don=$id;";

    // 3. Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
    $resultSelect = sqlsrv_query($conn, $sqlSelect);
    $Invoice = sqlsrv_fetch_array($resultSelect); // 1 record

    // Nếu không tìm thấy dữ liệu -> thông báo lỗi
    if(empty($Invoice)) {
        echo "Mã số hóa đơn: $id không tồn tại. Vui lòng kiểm tra lại.";
        die;
    }

    $query_time = sqlsrv_query($conn,"SELECT Thoi_gian_xuat FROM [dbo].[Hoa_don] WHERE So_hoa_don = '$id'");
    if ($query_time === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    else{
        $time = sqlsrv_fetch_array($query_time);
        $readonlyAttribute = ($time['Thoi_gian_xuat'] !== null) ? 'readonly' : '';
        $hideForm = ($time['Thoi_gian_xuat'] !== null) ? true : false;
        //echo $hideForm;echo $readonlyAttribute;
    }
    


    $querygomsp =       "SELECT sp.Ten, sp.Don_gia, gsp.So_luong, sp.Ma_vach
                        FROM [dbo].[Gom_san_pham] gsp
                        JOIN [dbo].[San_pham] sp ON gsp.Ma_vach = sp.Ma_vach
                        WHERE gsp.So_hoa_don = ?";

    $querygomCOMBO =   "SELECT  ct.Ten_chuong_trinh, cb.Gia, gcb.So_luong, cb.Ma_chuong_trinh
                        FROM [dbo].[Gom_combo] gcb
                        JOIN [dbo].[COMBO] cb ON gcb.Ma_combo = cb.Ma_chuong_trinh
                        JOIN [dbo].[Chuong_trinh_khuyen_mai] ct
                        ON gcb.Ma_combo = ct.Ma_chuong_trinh
                        WHERE gcb.So_hoa_don = ?";

    $params = array($id);

    $resultsp = sqlsrv_query($conn, $querygomsp, $params);
    $resultcb = sqlsrv_query($conn, $querygomCOMBO, $params);

    

    $data = [];
    $rowNum = 1;
    while ($row = sqlsrv_fetch_array($resultsp)) {
        $data[] = array(
            'rowNum' => $rowNum,
            'Ten' => $row['Ten'],
            'So_luong' => $row['So_luong'],
            'Don_gia' => $row['Don_gia'],
            'Ma_vach' => $row['Ma_vach'],
        );
        $rowNum++;
    }
    while ($row = sqlsrv_fetch_array($resultcb)) {
        $data[] = array(
            'rowNum' => $rowNum,
            'Ten' => $row['Ten_chuong_trinh'],
            'So_luong' => $row['So_luong'],
            'Don_gia' => $row['Gia'],
            'Ma_vach' => $row['Ma_chuong_trinh'],
        );
        $rowNum++;
        }
    $sotien = sqlsrv_query($conn,  "SELECT So_tien_giam 
        FROM [dbo].[Khuyen_mai_theo_so_tien] km 
        JOIN [dbo].[Hoa_don] hd ON hd.Ma_chuong_trinh = km.Ma_chuong_trinh
        WHERE hd.So_hoa_don ='$id'");

    $phantram = sqlsrv_query($conn,"SELECT Phan_tram_giam
        FROM [dbo].[Khuyen_mai_theo_phan_tram] km JOIN [dbo].[Hoa_don] hd
        ON hd.Ma_chuong_trinh = km.Ma_chuong_trinh
        WHERE hd.So_hoa_don = '$id'");

    $giam_gia = sqlsrv_query($conn,"SELECT So_tien_giam 
        FROM [dbo].[Hoa_don] hd JOIN [dbo].[Phieu_giam_gia] pg ON hd.Ma_giam_gia = pg.Ma_giam_gia 
        WHERE hd.So_hoa_don = '$id'");
    ?>
    
    <!-- Main content -->
    <div class="container">
        <h1>Hóa đơn</h1>

        <form name="frmEdit" id="frmEdit" method="post" action="hoadon.php" class="form">
            <table class="table" id="tab-user">
                <tr>
                    <td>Tên hóa đơn</td>
                    <td><input type="text" name="Ten_hoa_don" id="Ten_hoa_don" class="form-control" value="<?php echo $Invoice['Ten_hoa_don'] ?>" /></td>
                </tr>
                <tr>
                    <td>Mã khách hàng</td>
                    <td><input type="text" name="Ma_khach_hang" id="Ma_khach_hang" class="form-control" value="<?php echo $Invoice['Ma_khach_hang'] ?>"  /></td>
                </tr>
                <tr>
                    <td>Mã số nhân viên duyệt</td>
                    <td><input name="Ma_so_nhan_vien_duyet" id="Ma_so_nhan_vien_duyet" class="form-control" value="<?php echo $Invoice['Ma_so_nhan_vien_duyet'] ?>" /></td>
                </tr>
                <tr>
                    <td>Mã giảm giá (Dành cho thành viên)</td>
                    <td><input type="text" name="Ma_giam_gia" id="Ma_giam_gia" class="form-control" value="<?php echo $Invoice['Ma_giam_gia'] ?>" <?php echo $readonlyAttribute?>></td>
                </tr>
                <tr>
                    <td>Mã chương trình khuyến mãi</td>
                    <td><input type="text" name="Ma_chuong_trinh" id="Ma_chuong_trinh" class="form-control" value="<?php echo $Invoice['Ma_chuong_trinh'] ?>" <?php echo $readonlyAttribute?>/></td>
                </tr>
                <tr>
                    <td>Mã chi nhánh</td>
                    <td><input type="text" name="Ma_chi_nhanh" id="Ma_chi_nhanh" class="form-control" value="<?php echo $Invoice['Ma_chi_nhanh'] ?>" /></td>
                </tr>
                <tr>
                    <td>Số hóa đơn</td>
                    <td><input type="text" name="So_hoa_don" id="So_hoa_don" class="form-control" value="<?php echo $id ?>" readonly/></td>
                </tr>
                
            </table>
            <button type="button" name="btnSubmit" class="btn-Submit btn-primary" >
            <i class="fas fa-save"></i> Lưu thay đổi
            </button>
            <td><?php 
            if (isset($_GET['err'])) {
                $errors = explode(",", urldecode($_GET['err']));
            
                foreach ($errors as $error) {
                    echo "<p>Error: $error</p>";
                }
            } else {
                echo "<p>Totally normal.</p>";
            }
            ?></td>
            <?php if (!$hideForm): ?>
                <button
                 type='button' class='btn-delete btn-danger' data-bs-So_hoa_don='<?php echo $Invoice['So_hoa_don'] ?>' data-bs-target='#Delete' data-bs-toggle='modal'> <i class="fa-solid fa-file"></i>Xuất hóa đơn
                </button>
            <?php endif; ?>
            <?php
            ?>
        </form>
    </div>
    <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xuất hóa đơn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="lock.php" method="post">
                        <div class="modal-body">
                            <input type="text" name='So_hoa_don' class="form-control my-2" readonly/>
                            <p>Sau khi xuất không thể hoàn tác. Xác nhận?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary btn-outline-light" type="button" data-bs-dismiss="modal">Đóng lại</button>
                            <button class="btn btn-danger btn-outline-light" type="submit">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <div class="container">
<h1> Giỏ hàng </h1>
<form name="frmCreate" id="frmCreate" method="post" action="giohang.php" class="form">
<input type="hidden" name="id"         value = <?php echo $id?>>
    <table class="table table-borderd" id = "tb-giohang">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) : ?>
                    <tr>
                        <td><?php echo $row['rowNum']; ?></td>
                        <td><?php echo $row['Ten']; ?></td>
                        <td>
                            <input type="number" name="so_luong[]" value = <?php echo $row['So_luong']; ?>  <?php echo $readonlyAttribute?> min ="0">
                            <input type="hidden" name="ma_vach[]"  value = <?php echo $row['Ma_vach']; ?>>
                            
                        </td>
                        <td><?php echo $row['Don_gia']; ?></td>

                        <td>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>
                        <th>Giảm giá thành viên</th>
                        <th></th>
                        <th>
                        <?php
                        if(sqlsrv_has_rows($giam_gia)){
                        $so_tien_giam = sqlsrv_fetch_array($giam_gia)['So_tien_giam'];
                        echo(0-$so_tien_giam);}
                        else echo(0);
                        ?>
                        </th>
                    </td>
                </tr>
                <tr>
                    <td>
                        <th>Khuyến mãi</th>
                        <th></th>
                        <th>
                        <?php
                        if (sqlsrv_has_rows($phantram)) {
                            $phan_tram_giam = sqlsrv_fetch_array($phantram)['Phan_tram_giam'];
                            echo(0-$phan_tram_giam).'%';
                        }
                        elseif (sqlsrv_has_rows($sotien)) {
                            $so_tien_giam = sqlsrv_fetch_array($sotien)['So_tien_giam'];
                            echo(0-$so_tien_giam);
                        }else echo('0')
                        ?>
                        </th>
                    </td>
                </tr>

                <tr>
                    <td>
                        <th>Thành tiền</th>
                        <th></th>
                        <th><?php
                        $Tong_tien = sqlsrv_query($conn, "SELECT Tong_tien FROM [dbo].[Hoa_don] WHERE So_hoa_don = $id");
                        if (sqlsrv_has_rows($Tong_tien)) {
                        $fetched = sqlsrv_fetch_array($Tong_tien);
                        echo (0+$fetched['Tong_tien']);}
                        ?>
                        </th>
                    </td>
                </tr>
                <tr>
                </tr>
            </tbody>
        </table>
        <?php if (!$hideForm): ?>
        <button type="button" name="btnSave" class="btn-Save btn-primary" >
        <i class="fas fa-save"></i> Lưu thay đổi
        </button>
        <?php endif; ?>
</form>
</div>

    <?php
        $queryallsp= "SELECT * FROM [dbo].[San_pham]";
        $queryallcb = "SELECT ct.Ten_chuong_trinh, cb.Gia, cb.Ma_chuong_trinh FROM [dbo].[COMBO] cb JOIN [dbo].[Chuong_trinh_khuyen_mai] ct ON cb.Ma_chuong_trinh = ct.Ma_chuong_trinh";
        
        $result_allsp = sqlsrv_query($conn, $queryallsp);
        $result_allcb = sqlsrv_query($conn, $queryallcb);

        while ($row = sqlsrv_fetch_array($result_allsp)) {
            $data_all[] = array(
                'rowNum' => $rowNum,
                'Ten' => $row['Ten'],
                'So_luong' => $row['So_luong'],
                'Don_gia' => $row['Don_gia'],
                'Ma_vach' => $row['Ma_vach'],
            );
            $rowNum++;
            }
        while ($row = sqlsrv_fetch_array($result_allcb)) {
            $data_all[] = array(
                'rowNum' => $rowNum,
                'Ten' => $row['Ten_chuong_trinh'],
                'So_luong' => 'N/A',
                'Don_gia' => $row['Gia'],
                'Ma_vach' => $row['Ma_chuong_trinh'],
            );
            $rowNum++;
            }
    ?>
    <div class = 'container'>
    <?php if (!$hideForm): ?>
    <h1> Đang bán </h1>
    <input type="text" id="searchInput" class = "right-align m-1" placeholder="Tìm kiếm...">
            <select id="searchColumn" >
                <option value="Ten_san_pham">Tên sản phẩm</option>
            </select>
    <form name="frmBuy" id="frmBuy" method="post" action="purchase.php" class="form">
    <input type="hidden" name="id"         value = <?php echo $id?>>
    <table class="table table-borderd" id="tab-prod">
            <thead>
                <tr>
                    <th class="sortable" data-column="Ten_san_pham">Tên sản phẩm</th>
                    <th class="sortable" data-column="Kho">Kho</th>
                    <th class="sortable" data-column="Don_gia">Đơn giá</th>
                    <th>Số lượng mua</th>                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_all as $row) : ?>
                    <tr>
                        <td><?php echo $row['Ten']; ?></td>
                        <td><?php echo $row['So_luong']; ?></td>
                        <td><?php echo $row['Don_gia']; ?></td>
                        <td>
                        <input type="number" name="quantity[]" value="0" min ="0">
                        <input type="hidden" name="barcode[]" value="<?php echo $row['Ma_vach']; ?>">
                        </td>
                    </tr>                
                <?php endforeach; ?>
            </tbody>
        </table>
        <td colspan="2">
            <button name="btnBuy" class="btn-Buy btn-primary"><i class="fas fa-save"></i> Thêm vào giỏ hàng</button>
        </td>
    </form>
<?php endif; ?>
                </div>
                

            
                
                <?php
                    
                ?>
        
    <!-- Liên kết JS Jquery bằng CDN -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <!-- Liên kết JS Popper bằng CDN -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- Liên kết JS Bootstrap bằng CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Liên kết JS FontAwesome bằng CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script src="index.js"></script>
</body>

</html>