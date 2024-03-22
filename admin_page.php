<?php
session_start();
require_once("entity/employee.class.php");
require_once("config/db.class.php");

// Kiểm tra quyền truy cập của người dùng
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: 404.php");
    exit();
}

// Xử lý đăng xuất
if(isset($_POST['logout'])) {
    // Xóa tất cả các biến session
    session_unset();
    // Hủy session
    session_destroy();
    // Chuyển hướng người dùng về trang login
    header("Location: login.php");
    exit();
}

// Thêm nhân viên
if (isset($_POST['add_employee'])) {
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    $new_employee = new Employee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);
    $result = $new_employee->save();

    if ($result) {
        echo "<p>Thêm nhân viên thành công!</p>";
    } else {
        echo "<p>Thêm nhân viên thất bại!</p>";
    }
}

// Xóa nhân viên
if (isset($_POST['delete_employee'])) {
    $ma_nv = $_POST['ma_nv'];

    $result = Employee::deleteById($ma_nv);

    if ($result) {
        echo "<p>Xóa nhân viên thành công!</p>";
    } else {
        echo "<p>Xóa nhân viên thất bại!</p>";
    }
}

// Sửa thông tin nhân viên
if (isset($_POST['edit_employee'])) {
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    $result = Employee::update($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);

    if ($result) {
        echo "<p>Cập nhật thông tin nhân viên thành công!</p>";
    } else {
        echo "<p>Cập nhật thông tin nhân viên thất bại!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        /* CSS cho trang admin_page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        form input[type="text"], form input[type="password"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        form button[type="submit"] {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        form button[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 3px;
        }

        .logout-btn {
            float: right;
            background-color: #f44336;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Page</h1>

        <!-- Form đăng xuất -->
        <form method="post">
            <button type="submit" name="logout" class="logout-btn">Đăng xuất</button>
        </form>

        <!-- Form thêm nhân viên -->
        <h2>Thêm nhân viên</h2>
        <form method="post">
            <input type="text" name="ma_nv" placeholder="Mã nhân viên" required><br>
            <input type="text" name="ten_nv" placeholder="Tên nhân viên" required><br>
            <input type="text" name="phai" placeholder="Giới tính" required><br>
            <input type="text" name="noi_sinh" placeholder="Nơi sinh" required><br>
            <input type="text" name="ma_phong" placeholder="Mã phòng" required><br>
            <input type="text" name="luong" placeholder="Lương" required><br>
            <button type="submit" name="add_employee">Thêm</button>
        </form>

        <!-- Form xóa nhân viên -->
        <h2>Xóa nhân viên</h2>
        <form method="post">
            <input type="text" name="ma_nv" placeholder="Mã nhân viên" required><br>
            <button type="submit" name="delete_employee">Xóa</button>
        </form>

        <!-- Form sửa thông tin nhân viên -->
        <h2>Sửa thông tin nhân viên</h2>
        <form method="post">
            <input type="text" name="ma_nv" placeholder="Mã nhân viên" required><br>
            <input type="text" name="ten_nv" placeholder="Tên nhân viên"><br>
            <input type="text" name="phai" placeholder="Giới tính"><br>
            <input type="text" name="noi_sinh" placeholder="Nơi sinh"><br>
            <input type="text" name="ma_phong" placeholder="Mã phòng"><br>
            <input type="text" name="luong" placeholder="Lương"><br>
            <button type="submit" name="edit_employee">Sửa</button>
        </form>
    </div>
</body>
</html>
