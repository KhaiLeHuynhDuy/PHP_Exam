<?php
session_start();
require_once("entity/user.class.php");
require_once("config/db.class.php");


// // Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng tới trang success hoặc admin_page
// if(isset($_SESSION['username'])) {
//     if($_SESSION['role'] == 'admin') {
//         header("Location: admin_page.php");
//         exit();
//     } else {
//         header("Location: index.php");
//         exit();
//     }
// }

// Kiểm tra nếu có dữ liệu được gửi từ form đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các trường `username` và `password` đã được gửi chưa
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Xác minh thông tin đăng nhập từ cơ sở dữ liệu
        $user = User::getByUsername($username);

        if ($user && $user->password == $password) {
            // Lưu thông tin đăng nhập vào session
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;
            $_SESSION['LOGIN_SUCCESS'] = true; // Thêm biến session để đánh dấu đăng nhập thành công

            // Chuyển hướng người dùng tới trang tương ứng
            if ($user->role == 'admin') {
                header("Location: admin_page.php");
                exit();
            } else {
                header("Location: success.php");
                exit();
            }
        } else {
            $_SESSION['LOGIN_SUCCESS'] = false; // Thêm biến session để đánh dấu đăng nhập thất bại
            exit();
        }
    } else {
        // Hiển thị thông báo lỗi nếu không có các trường username và password được gửi từ form
        echo "Missing username or password!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-form label {
            display: block;
            margin-bottom: 10px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 15px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php
            // Kiểm tra nếu có thông báo thành công hoặc thất bại
            if (isset($_SESSION['LOGIN_SUCCESS'])) {
                if ($_SESSION['LOGIN_SUCCESS']) {
                    echo "<p class='success-message'>Login successful!</p>";
                } else {
                    echo "<p class='error-message'>Login failed. Please try again!</p>";
                }
                // Xóa biến session để không hiển thị thông báo lại khi refresh trang
                unset($_SESSION['LOGIN_SUCCESS']);
            }
        ?>
        <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
