<?php
session_start();
include 'config.php'; // Thay thế kết nối PDO bằng kết nối MySQLi từ config.php

// Xử lý đăng ký
if (isset($_POST['signup'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        $signup_success = "Đăng ký thành công! Vui lòng đăng nhập.";
    } else {
        $signup_error = "Lỗi: " . $stmt->error;
    }
    $stmt->close();
}

// Xử lý đăng nhập
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: home.php");
        exit();
    } else {
        $signin_error = "Email hoặc mật khẩu không đúng.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Phần HTML giữ nguyên như cũ -->
</html>
<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>