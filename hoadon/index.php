<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Bootstrap demo</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65' crossorigin='anonymous'>
</head>

<body>
    <main>

        <section class='py-5 text-center container'>
            <div class='row py-lg-5'>
                <div class='col-lg-6 col-md-8 mx-auto'>
                    <h1 class='fw-light'>Trang hóa đơn</h1>
                    <p>
                        <a href='../view' class='btn btn-secondary my-2'>Trở lại</a>
                    </p>
                </div>
            </div>
        </section>


    </main>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4' crossorigin='anonymous'></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống chuỗi cửa hàng OrvalK</title>

    <!-- Liên kết CSS Bootstrap bằng CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

    <!-- Main content -->
    <div class="container">
        <h1>Danh sách Hóa đơn</h1>

        <?php
        // Truy vấn database để lấy danh sách
        // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
        include_once(__DIR__ . '/../connectDB.php');

        // 2. Chuẩn bị câu truy vấn $sql
        $conn = OpenCon();
        $sql = "SELECT * FROM [dbo].[Hoa_don]";

        // 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
        $result = sqlsrv_query($conn, $sql);

        // 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tách để sử dụng
        // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
        // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
        $data = [];
        $rowNum = 1;
        while ($row = sqlsrv_fetch_array($result)) {
            $data[] = array(
                'rowNum' => $rowNum, // sử dụng biến tự tăng để làm dữ liệu cột STT
                'So_hoa_don' => $row['So_hoa_don'],
                'Ten_hoa_don' => $row['Ten_hoa_don'],
                'Thoi_gian_xuat' => $row['Thoi_gian_xuat']instanceof DateTime ? $row['Thoi_gian_xuat']->format('Y-m-d') : null,
                'Ma_khach_hang' => $row['Ma_khach_hang'],
                'Ma_giam_gia' => $row['Ma_giam_gia'],
                'Ma_chuong_trinh' => $row['Ma_chuong_trinh'],
                'Ma_so_nhan_vien_duyet' => $row['Ma_so_nhan_vien_duyet'],
                'CCCD_nhan_vien_duyet' => $row['CCCD_nhan_vien_duyet'],
                'Ma_chi_nhanh' => $row['Ma_chi_nhanh'],
                'Tong_tien' => $row['Tong_tien'],
            );
            $rowNum++;
        }
        ?>

        <!-- Button Thêm mới -->
        <a href="newivoice.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
        <input type="text" id="searchInput" class = "right-align m-1" placeholder="Tìm kiếm...">
            <select id="searchColumn">
                <option value="So_hoa_don">Số hóa đơn</option>
                <option value="Ten_hoa_don">Tên hóa đơn</option>
                <option value="Ma_khach_hang">Mã khách hàng</option>
                <option value="Ma_giam_gia">Mã giảm_giá</option>
                <option value="Ma_chuong_trinh">Mã chương trình</option>'
                <option value="TMa_so_nhan_vien_duyet">Mã nhân viên</option>
                <option value="Ma_chi_nhanh">Chi nhánh</option>
            </select>

        <table class="table table-borderd"   id="tab-prod">
            <thead>
                <tr>
                    <th class="sortable" data-column="So_hoa_don">Số hóa đơn <i class="fas fa-sort right-align"></i></th>
                    <th class="sortable" data-column="Ten_hoa_don">Tên hóa đơn<i class="fas fa-sort right-align"></i></th>
                    <th class="sortable" data-column="Thoi_gian_xuat">Thời gian xuất<i class="fas fa-sort right-align"></i></th>
                    <th class="sortable" data-column="Ma_khach_hang">Mã khách hàng<i class="fas fa-sort right-align"></i></th>
                    <th>Mã giảm giá</th>
                    <th>Mã chương trình</th>
                    <th>Mã số nhân viên duyệt</th>
                    <th>CCCD nhân viên duyệt</th>
                    <th class="sortable" data-column="Ma_chi_nhanh">Mã chi nhánh<i class="fas fa-sort right-align"></i></th>
                    <th class="sortable" data-column="Tong_tien">Tổng tiền<i class="fas fa-sort right-align"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) : ?>
                    <tr>
                        <td><?php echo $row['So_hoa_don']; ?></td>
                        <td><?php echo $row['Ten_hoa_don']; ?></td>
                        <td><?php echo $row['Thoi_gian_xuat']; ?></td>
                        <td><?php echo $row['Ma_khach_hang']; ?></td>
                        <td><?php echo $row[ 'Ma_giam_gia']; ?></td>
                        <td><?php echo $row['Ma_chuong_trinh']; ?></td>
                        <td><?php echo $row['Ma_so_nhan_vien_duyet']; ?></td>
                        <td><?php echo $row['CCCD_nhan_vien_duyet']; ?></td>
                        <td><?php echo $row['Ma_chi_nhanh']; ?></td>
                        <td><?php echo $row['Tong_tien']; ?></td>
                        <td>
                            <!-- Button Sửa -->
                            <a href="edit.php?id=<?php echo $row['So_hoa_don']; ?>" id="btnUpdate" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Button Xóa -->
                            
                            <button type='button' class='btn-delete btn btn-danger' data-bs-So_hoa_don='<?php echo $row['So_hoa_don'] ?>' data-bs-target='#Delete' data-bs-toggle='modal'><i class="fas fa-trash-alt"></i></button>
                                </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="delete.php" method="post">
                        <div class="modal-body">
                            <input type="text" name='So_hoa_don' class="form-control my-2" readonly/>
                            <p>Xác nhận xóa ?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary btn-outline-light" type="button" data-bs-dismiss="modal">Đóng lại</button>
                            <button class="btn btn-danger btn-outline-light" type="submit">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   

    <!-- Liên kết JS Jquery bằng CDN -->
    <!-- Bao gồm jQuery từ CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- Liên kết JS Popper bằng CDN -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- Liên kết JS Bootstrap bằng CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Liên kết JS FontAwesome bằng CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script src="index.js"></script>
    
</body>

</html>