<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Nhân viên</title>

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
    <!-- Add more navigation links as needed -->
</div>
<body>
    <main>
    <div class="container">
        <h1 class="my-3">Quản lí nhân viên</h1>
        <hr>
        <?php
        if (isset($_GET['err'])) {
            $errors = explode(",", $_GET['err']);
        
            foreach ($errors as $error) {
                echo "<p>Error: $error</p>";
            }
        } else {
            echo "<p>Totally normal.</p>";
        }
        ?>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add">Thêm nhân viên</button>
        <a href="salary.php" class="btn btn-primary mb-3">Tính lương nhân viên</a>
        <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm NV mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="add.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input class="form-control my-2" type="text" placeholder="Họ và tên" name="Ho_va_ten" />
                            </div>
                            <div class="form-group">
                                <label>Mã số nhân viên</label>
                                <input class="form-control my-2" placeholder="Mã số" name="Ma_so" />
                            </div>
                            <div class="form-group">
                                <label>Số CCCD</label>
                                <input class="form-control my-2" placeholder="CCCD" name="CCCD" />
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input class="form-control my-2"  placeholder="Địa chỉ" name="Dia_chi" />
                            </div>
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input class="form-control my-2" placeholder="YYYY-MM-DD" name="Ngay_sinh" />
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <input class="form-control my-2" type = "text" placeholder="Giới tính" name="Gioi_tinh" />
                            </div>
                            <div class="form-group">
                                <label>Mã chi nhánh</label>
                                <input class="form-control my-2"  placeholder="Mã chi nhánh" name="Ma_chi_nhanh" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Đóng lại</button>
                            <button class="btn btn-primary" type="submit">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-striped mt-2" id="tab-user">
            <thead>
                <tr>
                    <th scope="col">Họ và tên</th>
                    <th scope="col">Mã số nhân viên</th>
                    <th scope="col">Số CCCD</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Ngày sinh</th>
                    <th scope="col">Giới tính</th>
                    <th scope="col">Mã chi nhánh</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require_once('connectDB.php');

                $conn = OpenCon();
                $query = "SELECT * FROM [dbo].[Nhan_vien]";

                $result = sqlsrv_query($conn,$query);
                $data = [];
                if (sqlsrv_has_rows($result)) {
                    while ($row =sqlsrv_fetch_array($result)){
                        $data[] = array(
                                "Ho_va_ten"=> $row["Ho_va_ten"],
                                "Ma_so" => $row['Ma_so'],
                                "CCCD" => $row['CCCD'] ,
                                "Dia_chi" => $row['Dia_chi'],
                                'Ngay_sinh' => $row['Ngay_sinh'] instanceof DateTime ? $row['Ngay_sinh']->format('Y-m-d') : null,
                                "Gioi_tinh" => $row['Gioi_tinh'],
                                "Ma_chi_nhanh" => $row['Ma_chi_nhanh']
                        );
        
                        }
                }
                
                    foreach ($data as $row) :
                    
                    ?>  
                            
                            <tr class="justify-content-center">
                            <th class='align-middle'><?php echo $row['Ho_va_ten'] ?></th>
                            <td class='align-middle'><?php echo $row['Ma_so'] ?></td>
                            <td class='align-middle'><?php echo $row['CCCD'] ?></td>
                            <td class='align-middle'><?php echo $row['Dia_chi'] ?></td>
                            <td class='align-middle'><?php echo $row['Ngay_sinh']  ?></td> 
                            <td class='align-middle'><?php echo $row['Gioi_tinh'] ?></td>
                            <td class='align-middle'><?php echo $row['Ma_chi_nhanh'] ?></td>
                            
                            <td class='align-middle'>
                                <div class="d-inline-flex">
                                    <button type='button' class='btn-edit btn btn-primary m-1' data-bs-Ma_so='<?php echo $row['Ma_so'] ?>' data-bs-Dia_chi='<?php echo $row['Dia_chi'] ?>' data-bs-Ngay_sinh='<?php echo $row['Ngay_sinh'] ?>' data-bs-Ma_chi_nhanh='<?php echo $row['Ma_chi_nhanh'] ?>' data-bs-target='#Edit' data-bs-toggle='modal'>Edit</button>
                                    <button type='button' class='btn-delete btn btn-danger m-1' data-bs-Ma_so='<?php echo $row['Ma_so'] ?>' data-bs-target='#Delete' data-bs-toggle='modal'>Delete</button>
                                </div>
                            </td>
                        </tr>
                <?php
                    endforeach;
            ?>
            </tbody>
        </table>
        <div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="Edit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật thông tin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="edit.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Mã số nhân viên</label>
                                <input class="form-control my-2" placeholder="Ma_so" name="Ma_so" readonly />
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input class="form-control my-2"  placeholder="Dia_chi" name="Dia_chi" />
                            </div>
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input class="form-control my-2" placeholder="YYYY-MM-DD" name="Ngay_sinh" />
                            </div>
                            <div class="form-group">
                                <label>Mã chi nhánh</label>
                                <input class="form-control my-2" placeholder="Ma_chi_nhanh" name="Ma_chi_nhanh" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Đóng lại</button>
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xóa NV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="delete.php" method="post">
                        <div class="modal-body">
                            <input type="text" name="Ma_so" class="form-control my-2" readonly />
                            <p>Bạn chắc chưa ?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary btn-outline-light" type="button" data-bs-dismiss="modal">Đóng lại</button>
                            <button class="btn btn-danger btn-outline-light" type="submit">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    </main>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4' crossorigin='anonymous'></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="index.js"></script>
</body>

</html>