<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Bootstrap demo</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65' crossorigin='anonymous'>
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
    <a href='../' class='btn btn-secondary my-2'>Trở lại đăng nhập</a>
    <!-- Add more navigation links as needed -->
</div>
<body>
<main>
<?php
    include_once(__DIR__ . '/../connectDB.php');
    $conn = OpenCon();
?>
<section class='py-5 text-center container'>
    <div class='row py-lg-5'>
        <div class='col-lg-6 col-md-8 mx-auto'>
            <h1 class='fw-light'>OUR BEST PROMOTIONS</h1>
        </div>
    </div>
</section>
<div class="container">
        <form name="frmCreate" method="post" action="" class="form">
            <table class="table">
                <tr>
                    <td><input type="text" name="Ma_chi_nhanh" placeholder="Mã chi nhánh" id="Ma_chi_nhanh" class="form-control" /></td>
                    <td><button name="btnFetch" class="btn btn-primary"><i class="fas fa-save"></i> Tra cứu</button></td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_POST['btnFetch']) ) {
            $ma_cn = $_POST['Ma_chi_nhanh'];
            $data = array();
            if (empty($ma_cn)) {
                echo('Nhập mã chi nhánh');
            }else{
                $querymacn = "SELECT * FROM [dbo].[Chi_nhanh] cn where cn.Ma_chi_nhanh = $ma_cn";
                $resultcn = sqlsrv_query($conn, $querymacn);
                if (!sqlsrv_has_rows($resultcn)) {
                    echo('Chi nhánh không tồn tại');
                }else{
                    $sql = "SELECT * FROM dbo.BestSeller($ma_cn) ORDER BY SoLanApDung DESC";
                    $result = sqlsrv_query($conn, $sql);
                    if ($result != false) {
                        while ($row = sqlsrv_fetch_array($result)) {
                            $data[] = array(
                                'Ma_ct' => $row["Ma_chuong_trinh"],
                                'Ten_ct'=> $row["Ten_chuong_trinh"],
                                'So_lan'=> $row["SoLanApDung"],
                            );
                        }
                    }else{
                        die(print_r(sqlsrv_errors(), true));
                    }
                }
            }   
        
?>
    </div>

<div class = "container">
<table class="table table-borderd"   id="tab-prod">
            <thead >
                <tr>
                    <th>Mã chương trình </th>
                    <th>Tên chương trình</th>
                    <th>Số lần áp dụng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) : ?>
                    <tr>
                        <td><?php echo $row["Ma_ct"]; ?></td>
                        <td><?php echo $row["Ten_ct"]; ?></td>
                        <td><?php echo $row["So_lan"]; ?></td>
                    </tr>
                <?php endforeach;} ?>
            </tbody>
        </table>
</div>
<img src="../images/Main.jpg" alt="" text="hi">
</img>

</main>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4' crossorigin='anonymous'></script>

</body>