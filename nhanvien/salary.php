<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống chuỗi cửa hàng OrvalK</title>

    <!-- Liên kết CSS Bootstrap bằng CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
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

    <!-- Main content -->
    <div class="container">
        <h1>Tính lương nhân viên</h1>

        <form name="frmCreate" method="post" action="" class="form">
            <table class="table">
                <tr>
                    <td>Mã nhân viên</td>
                    <td><input type="text" name="Ma_nhan_vien" placeholder="Để trống để tính cho tất cả nhân viên" id="Ma_nhan_vien" class="form-control" /></td>
                </tr>
                <tr>
                    <td>Tháng</td>
                    <td><input type="text" name="Thang" id="Thang" class="form-control" /></td>
                </tr>
                <tr>
                    <td>Năm</td>
                    <td><input type="text" name="Nam" id="Nam" class="form-control" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button name="btnSave" class="btn btn-primary"><i class="fas fa-save"></i> Tính</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    // Truy vấn database
    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once(__DIR__ . '/../connectDB.php');
    $conn = OpenCon();
    $salary = array();
    if (isset($_POST['btnSave'])) {
    $Ma_nv = $_POST['Ma_nhan_vien'];
    $mon = $_POST['Thang'];
    $year = $_POST['Nam'];
    $errors = array();
    

    if (empty($year)) {
        $errors[] = "Vui lòng nhập năm cần tính";
    }

    if (empty($mon)) {
        $errors[] = "Vui lòng nhập tháng cần tính";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . '<br />';
        }
        return;
    }


    $quer_sal = "SELECT dbo.TinhLuongNhanVien(?, ?, ?) AS Luong";
    $params = array($Ma_nv, $mon, $year);

    if (empty($Ma_nv)) {
        $sql = "SELECT Ho_va_ten, Ma_so FROM [dbo].[Nhan_vien]";
        $ma_so = sqlsrv_query($conn, $sql);

        while ($row = sqlsrv_fetch_array($ma_so)) {
            $params[0] = $row['Ma_so'];
            $sal = sqlsrv_query($conn, $quer_sal, $params);
            if ($sal != false) {
            $salary[] = array(
                'Ma_so' => $params[0],
                'Ho_ten' => $row['Ho_va_ten'],
                'Luong' => sqlsrv_fetch_array($sal)['Luong']
            );
            ;
            }else{
                die(print_r(sqlsrv_errors(), true));
            }
        }
    } else {
        $sal = sqlsrv_query($conn, $quer_sal, $params);
        ;
        $Luong = sqlsrv_fetch_array($sal)['Luong'];
        $salary[] = array( 'Ma_so' => $Ma_nv,
                            'Ho_ten' => sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT Ho_va_ten FROM [dbo].[Nhan_vien] WHERE Ma_so = $Ma_nv"))['Ho_va_ten'],
                            'Luong' => $Luong);
    }
    sqlsrv_close($conn);

    // Process $salary array as needed

    // Redirect or other actions
    // header('location:index.php');
    }
?>

<div class="container">
<table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th scope="col">Họ và tên</th>
                    <th scope="col">Mã số nhân viên</th>
                    <th scope="col">Lương</th>
                </tr>
            </thead>
            <tbody>     
        <?php foreach ($salary as $row) : ?>  
                            
                         <tr class="justify-content-center">
                            <th class='align-middle'><?php echo $row['Ho_ten'] ?></th>
                            <td class='align-middle'><?php echo $row['Ma_so'] ?></td>
                            <td class='align-middle'><?php echo $row['Luong'] ?></td>
                        </tr>
        <?php endforeach;?>
            </tbody>
</div>

    <!-- Liên kết JS Jquery bằng CDN -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <!-- Liên kết JS Popper bằng CDN -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- Liên kết JS Bootstrap bằng CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Liên kết JS FontAwesome bằng CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</body>

</html>