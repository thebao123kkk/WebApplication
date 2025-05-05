<?php
session_start();
include 'config.php'; // Thay thế kết nối PDO bằng kết nối MySQLi từ config.php

// Xử lý đăng ký
if (isset($_POST['signup'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Kiểm tra xem hash có được tạo thành công không
    if (!$password) {
        $signup_error = "Lỗi khi mã hóa mật khẩu";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            $signup_success = "Đăng ký thành công! Vui lòng đăng nhập.";
        } else {
            // Hiển thị lỗi cụ thể từ MySQL
            $signup_error = "Lỗi đăng ký: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Xử lý đăng nhập

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: test.php");
            exit();
        } else {
            $signin_error = "Mật khẩu không đúng";
        }
    } else {
        $signin_error = "Email không tồn tại";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <link rel="stylesheet" href="style4Form.css" />
    <title>Login Page | VHuB</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="form.php">
                <img src="img/logoicon.png" alt="Logo" class="form-logo" />
                <h2 class="form-title">Get Started!</h2>
                <p class="form-subtitle">Welcome to VHub! Let's create your account!</p>
                <hr class="form-divider" />
                
                <?php if (isset($signup_success)): ?>
                    <div class="alert alert-success"><?php echo $signup_success; ?></div>
                <?php elseif (isset($signup_error)): ?>
                    <div class="alert alert-danger"><?php echo $signup_error; ?></div>
                <?php endif; ?>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="ms.ella@gmail.com" required />
                
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Ella Mary" required />
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="********" required />

                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="form.php">
                <img src="img/logoicon.png" alt="Logo" class="form-logo" />
                <h2 class="form-title">Sign in</h2>
                <hr>
                
                <?php if (isset($signin_error)): ?>
                    <div class="alert alert-danger"><?php echo $signin_error; ?></div>
                <?php endif; ?>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="ms.ella@gmail.com" required />
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="********" required />

                <button type="submit" name="signin" class="btn-red">Sign in</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script4Form.js"></script>
</body>
</html>
<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>