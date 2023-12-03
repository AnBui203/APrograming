
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="index.css">
  <link href="index.css" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Quản lý thành viên</title>
</head>

<body>
<nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
    <a href="index.php">CircleK by Night Stalker - Quản lý thành viên</a>
  </nav>

  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    <a href="addThanhVien.php" class="btn btn-dark mb-3">Thêm thành viên mới</a>

    <input type="text" id="filterInput" placeholder="Tìm kiếm...">

    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">Mã thành viên</th>
          <th scope="col">CCCD</th>
          <th scope="col">Họ và tên</th>
          <th scope="col">Giới tính</th>
          <th scope="col">Điểm tích lũy</th>
          <th scope="col">Mã khách hàng</th>
          <th scope="col">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once('connectDB.php');

        $conn = OpenCon();
        $query = "SELECT * FROM Thanh_vien";

        //$result = mysqli_query($conn,$query);
        $stmt = sqlsrv_query($conn, $query);
        //if ($result->num_rows > 0) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        ?>
          <tr class="table-row">
            <td><?php echo $row["Ma_thanh_vien"] ?></td>
            <td><?php echo $row["CCCD"] ?></td>
            <td><?php echo $row["Ho_va_ten"] ?></td>
            <td><?php echo $row["Gioi_tinh"] ?></td>
            <td><?php echo $row["Diem_tich_luy"] ?></td>
            <td><?php echo $row["Ma_khach_hang"] ?></td>
            <td>
              <a href="editThanhVien.php?maThanhVien=<?php echo $row["Ma_thanh_vien"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="removeThanhVien.php?maThanhVien=<?php echo $row["Ma_thanh_vien"] ?>&CCCD=<?php echo $row["CCCD"] ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php
        }
    //}
        ?>
      </tbody>
    </table>
  </div>
  
  <section class='py-5 text-center container'>
      <div class='row py-lg-5'>
          <div class='col-lg-6 col-md-8 mx-auto'>
          <div class='col-lg-6 col-md-8 mx-auto'>
              <p>
                  <a href='../view' class='btn btn-secondary my-2'>Trở lại trang chính</a>
              </p>
          </div>
          </div>
      </div>
  </section>

  <script>
  function filterTable() {
    var input = document.getElementById("filterInput").value.toUpperCase();
    var rows = document.getElementsByClassName("table-row");
  
    for (var i = 0; i < rows.length; i++) {
      var cells = rows[i].getElementsByTagName("td");
      var shouldShowRow = false;
  
      for (var j = 0; j < cells.length; j++) {
        var cell = cells[j];
        if (cell) {
          var cellText = cell.textContent.toUpperCase();
  
          if (cellText.includes(input)) {
            shouldShowRow = true;
            break;
          }
        }
      }
  
      rows[i].style.display = shouldShowRow ? "" : "none";
    }
  }
  
  document.getElementById("filterInput").addEventListener("keyup", filterTable);
</script>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>
