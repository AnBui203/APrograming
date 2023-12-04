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
    <a href="./index.php">Hóa đơn</a>
    <a href="../nhanvien/">Nhân Viên</a>
    <a href="../thanhvien">Thành Viên</a>
    <!-- Add more navigation links as needed -->
</div>
<body>

    <!-- Main content -->
    <div class="container">
        <h1>Tạo Hóa đơn mới</h1>

        <form name="frmCreate" method="post" action="" class="form">
            <table class="table">
                <tr>
                    <td>Số hóa đơn</td>
                    <td><input type="text" name="So_hoa_don" id="So_hoa_don" class="form-control" /></td>
                </tr>
                <tr>
                    <td>Tên hóa đơn</td>
                    <td><input type="text" name="Ten_hoa_don" id="Ten_hoa_don" class="form-control" /></td>
                </tr>
                <tr>
                    <td>Mã khách hàng</td>
                    <td><input type="text" name="Ma_khach_hang" id="Ma_khach_hang" class="form-control"></textarea></td>
                </tr>
                <tr>
                    <td>Mã nhân viên duyệt</td>
                    <td><input type="text" name="Ma_nhan_vien_duyet" id="Ma_nhan_vien_duyet" class="form-control"></textarea></td>
                </tr>
                <tr>
                    <td>Mã chi nhánh</td>
                    <td><input type="text" name="Ma_chi_nhanh" id="Ma_chi_nhanh" class="form-control"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button name="btnSave" class="btn btn-primary"><i class="fas fa-save"></i> Lưu dữ liệu</button>
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

    // 2. Người dùng mới truy cập trang lần đầu tiên (người dùng chưa gởi dữ liệu `btnSave` - chưa nhấn nút Save) về Server
    // có nghĩa là biến $_POST['btnSave'] chưa được khởi tạo hoặc chưa có giá trị
    // => hiển thị Form nhập liệu

    // Nếu biến $_POST['btnSave'] đã được khởi tạo
    // => Người dùng đã bấm nút "Lưu dữ liệu"
    if ( isset($_POST['btnSave']) ) {
        
        // 3. Nếu người dùng có bấm nút `Lưu dữ liệu` thì thực thi câu lệnh INSERT
        // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
        $so_hoa_don = $_POST['So_hoa_don'];
        $ten_hoa_don = $_POST['Ten_hoa_don'];
        $ma_khach_hang = $_POST['Ma_khach_hang'];
        $ma_nhan_vien = $_POST['Ma_nhan_vien_duyet'];
        $ma_chi_nhanh = $_POST['Ma_chi_nhanh'];

        // 4. Kiểm tra ràng buộc dữ liệu (Validation)
        // Tạo biến lỗi để chứa thông báo lỗi
        $errors = [];
        // --- Kiểm tra Mã nhà cung cấp (validate)
        // required (bắt buộc nhập <=> không được rỗng)
        if (empty($so_hoa_don)) {
            $errors['So_hoa_don'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $so_hoa_don,
                'msg' => 'Vui lòng nhập số hóa đơn'
            ];
        }
        if (!empty($so_hoa_don) && strlen($so_hoa_don) < 4) {
            $errors['So_hoa_don'][] = [
                'rule' => 'minlength',
                'rule_value' => 3,
                'value' => $so_hoa_don,
                'msg' => 'Số hóa đơn có ít nhất 4 kí tự số'
            ];
            
        }
        else{
            $querymaso = "SELECT * FROM [dbo].[Hoa_don] WHERE So_hoa_don = ?";
            $params = array($so_hoa_don);
            $result = sqlsrv_query($conn, $querymaso, $params);            
            if (sqlsrv_has_rows($result)) {
                $errors['So_hoa_don'][] = [
                    'msg' => 'Số hóa đơn đã tồn tại'
                ];
            }
        }
        if (empty($ten_hoa_don)) {
            $errors['Ten_hoa_don'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $ten_hoa_don,
                'msg' => 'Vui lòng nhập tên hóa đơn'
            ];
        }
        // maxlength 255 (tối đa 255 ký tự)
        if (!empty($ten_hoa_don) && strlen($ten_hoa_don) > 255) {
            $errors['Ten_hoa_don'][] = [
                'rule' => 'maxlength',
                'rule_value' => 255,
                'value' => $ten_hoa_don,
                'msg' => 'Tên hóa đơn không được vượt quá 255 ký tự'
            ];
        }
        if (empty($ma_nhan_vien)) {
                $errors['Ma_nhan_vien'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $ma_nhan_vien,
                'msg' => 'Vui lòng nhập mã nhân viên tạo đơn'
            ];
        }else{
            $querymaso = "SELECT * FROM [dbo].[Nhan_vien] WHERE Ma_so = ?";
            $paramsnv = array($ma_nhan_vien);
            $resultnv = sqlsrv_query($conn, $querymaso, $paramsnv);
            if (!sqlsrv_has_rows($resultnv)) {
                $errors['Ma_nhan_vien'][] = [
                    'msg' => 'Nhân viên không tồn tại'
                ];
            }
        }

        if (empty($ma_chi_nhanh)) {
                $errors['Ma_chi_nhanh'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $ma_chi_nhanh,
                'msg' => 'Vui lòng nhập mã chi nhánh'
            ];
        }else{
            $querymacn = "SELECT * FROM [dbo].[Chi_nhanh] cn where cn.Ma_chi_nhanh = ?";
            $paramscn = array($ma_chi_nhanh);
            $resultcn = sqlsrv_query($conn, $querymacn, $paramscn);
            if (!sqlsrv_has_rows($resultcn)) {
                $errors['Ma_chi_nhanh'][] = [
                    'msg' => 'Chi nhánh không tồn tại'
                ];
            }
        }
        if (empty($ma_khach_hang)) {
            $ma_khach_hang = 0;
        }
        // 5. Thông báo lỗi cụ thể người dùng mắc phải (nếu vi phạm bất kỳ quy luật kiểm tra ràng buộc)
        if (!empty($errors)) {
            // In ra thông báo lỗi
            // kèm theo dữ liệu thông báo lỗi
            foreach($errors as $errorField) {
                foreach($errorField as $error) {
                    echo $error['msg'] . '<br />';
                }
            }
            return;
        }else{
            $sqlInsert = "EXEC [dbo].[Them_hoa_don]  '$so_hoa_don', '$ten_hoa_don', '$ma_khach_hang', '$ma_nhan_vien', '$ma_chi_nhanh'";
            sqlsrv_query($conn, $sqlInsert);
        }

        

        // Code dùng cho DEBUG
        //var_dump($sqlInsert); die;

        // Thực thi INSERT
        

        // Đóng kết nối
        sqlsrv_close($conn);

        // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
        header('location:index.php');   
    }
    ?>

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