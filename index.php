<?php
require_once("config/db.class.php");
require_once("entity/employee.class.php");

// Số nhân viên trên mỗi trang
$employeesPerPage = 5;

// Trang hiện tại
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính vị trí bắt đầu của mỗi trang
$startIndex = ($currentPage - 1) * $employeesPerPage;

// Lấy danh sách nhân viên từ cơ sở dữ liệu
$employees = Employee::getAll($startIndex, $employeesPerPage);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 50px;
            max-height: 50px;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            text-decoration: none;
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            color: #333;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
        .pagination .active {
            background-color: #333;
            color: #fff;
        }
        .login-button {
            margin-top: 20px;
            text-align: center;
        }
        .login-button button {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }
        .login-button button:hover {
            background-color: #45a049;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Danh sách nhân viên</h1>
        <?php
        if (!empty($employees)) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Mã Nhân Viên</th>";
            echo "<th>Tên Nhân Viên</th>";
            echo "<th>Giới Tính</th>";
            echo "<th>Nơi Sinh</th>";
            echo "<th>Tên Phòng</th>";
            echo "<th>Lương</th>";
            echo "</tr>";
            
            foreach ($employees as $employee) {
                echo "<tr>";
                echo "<td>" . $employee->ma_nv . "</td>";
                echo "<td>" . $employee->ten_nv . "</td>";
                echo "<td>";
                // Kiểm tra giới tính và chèn hình ảnh tương ứng
                if ($employee->phai == 'NU') {
                    echo "<img src='img/anh1.jpg' alt='Woman'>";
                } else {
                    echo "<img src='img/anh2.jpg' alt='Man'>";
                }
                echo "</td>";
                echo "<td>" . $employee->noi_sinh . "</td>";
                echo "<td>" . $employee->ma_phong . "</td>";
                echo "<td>" . $employee->luong . "</td>";
                echo "</tr>";
            }

            echo "</table>";

            // Tính số lượng trang
            $totalPages = ceil(Employee::countAll() / $employeesPerPage);

            // Hiển thị phân trang
            echo "<div class='pagination'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='index.php?page=$i'>$i</a> ";
            }
            echo "</div>";
        } else {
            echo "Không có nhân viên.";
        }
        ?>
        <div class="login-button">
            <button onclick="window.location.href = 'login.php';">Login</button>
        </div>
    </div>
</body>
</html>
