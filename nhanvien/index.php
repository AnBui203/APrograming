<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Nhân viên</title>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65' crossorigin='anonymous'>
</head>

<body>
    <main>
    <div class="container">
        <a href="../view" class="btn btn-warning float-end">Trở lại</a>
        <h1 class="my-3">Quản lí nhân viên</h1>
        <hr>
        <?php
        if (isset($_GET['err'])) {
            echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">";
            echo "<strong>Error: </strong>" . $_GET['err'];
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
            echo "</div>";
        }
        ?>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add">Thêm NV</button>
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
                                <input class="form-control my-2" placeholder="Ngày sinh" name="Ngay_sinh" />
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <input class="form-control my-2" type = "text" placeholder="Giới tính" name="Gioi_tinh" />
                            </div>
                            <div class="form-group">
                                <label>Mã chi nhánh</label>
                                <input class="form-control my-2"  placeholder="Mã chi nhánh" name="Ma_chi_nhanh" />
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control my-2"  placeholder="SDT" name="SDT" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control my-2" placeholder="Email" name="Email" />
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
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require_once('connectDB.php');

                $conn = OpenCon();
                $query = "SELECT * FROM `Nhan_vien`;";

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    // OUTPUT DATA OF EACH ROW
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr class="justify-content-center">
                            <th class='align-middle' scope="row"><?php echo $row['Ho_va_ten'] ?></th>
                            <td class='align-middle'><?php echo $row['Ma_so'] ?></td>
                            <td class='align-middle'><?php echo $row['CCCD'] ?></td>
                            <td class='align-middle'><?php echo $row['Dia_chi'] ?></td>
                            <td class='align-middle'><?php echo $row['Ngay_sinh'] ?></td>
                            <td class='align-middle'><?php echo $row['Gioi_tinh'] ?></td>
                            <td class='align-middle'><?php echo $row['Ma_chi_nhanh'] ?></td>
                            <td class='align-middle'><?php echo $row['SDT'] ?></td>
                            <td class='align-middle'><?php echo $row['Email'] ?></td>
                            <td class='align-middle'>
                                <div class="d-inline-flex">
                                    <button type='button' class='btn-edit btn btn-primary m-1' data-bs-Ma_so='<?php echo $row['Ma_so'] ?>' data-bs-Dia_chi='<?php echo $row['Dia_chi'] ?>' data-bs-Ngay_sinh='<?php echo $row['Ngay_sinh'] ?>' data-bs-Ma_chi_nhanh='<?php echo $row['Ma_chi_nhanh'] ?>' data-bs-SDT='<?php echo $row['SDT'] ?>' data-bs-Email='<?php echo $row['Email'] ?>' data-bs-target='#Edit' data-bs-toggle='modal'>Edit</button>
                                    <button type='button' class='btn-delete btn btn-danger m-1' data-bs-Ma_so='<?php echo $row['Ma_so'] ?>' data-bs-target='#Delete' data-bs-toggle='modal'>Delete</button>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                }
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
                                <input class="form-control my-2" type="number" placeholder="Ma_so" name="Ma_so" readonly />
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input class="form-control my-2"  placeholder="Dia_chi" name="Dia_chi" />
                            </div>
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input class="form-control my-2" placeholder="Ngay_sinh" name="Ngay_sinh" />
                            </div>
                            <div class="form-group">
                                <label>Mã chi nhánh</label>
                                <input class="form-control my-2" type = "number" placeholder="Ma_chi_nhanh" name="Ma_chi_nhanh" />
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control my-2" type = "number" placeholder="SDT" name="SDT" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control my-2" placeholder="Email" name="Email" />
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
                            <input type="text" name="tenDangNhap" class="form-control my-2" readonly />
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
    <script src="index.js"></script>
</body>

</html>