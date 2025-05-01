<?php
session_start();
include 'config.php'; // Thay thế kết nối PDO bằng kết nối MySQLi từ config.php

// Xử lý đăng ký
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home | VHuB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style4Home.css">
  <link rel="icon" href="img/logo.ico" type="image/x-icon">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img id="logo" src="img/Logo50x50.png" alt="VL Logo">
      </a>
      
      <button class="navbar-toggler" type="button" title="Toggle navigation" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-3 align-items-center">
          <li class="nav-item">
            <a class="nav-link fw-bold" href="#">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
              Our Courses
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#"><span><img id="grammar" src="img/grammar.png" alt=""> Grammar</span></a></li>
              <li><a class="dropdown-item" href="#"><span><img id="vocab" src="img/vocab.png" alt=""> Vocabulary</span></a></li>
              <li><a class="dropdown-item" href="#"><span><img id="listen" src="img/listen.png" alt=""> Listening</span></a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link text-dark" href="#">Blog</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="#">Test</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="#">About</a></li>
          <li class="nav-item">
            <!-- Nút Log in -->
            <button id="sign-in" class="btn rounded-pill me-2 px-4 py-1" style="background-color: #fff8d4; border: 1px solid black;">Log in</button>
            <!-- Nút Sign up -->
            <button id="sign-up" class="btn rounded-pill px-4 py-1" style="background-color: #fff8d4; border: 1px solid #f58e42;">Sign up</button>
          </li>
        </ul>
        
      </div>
    </div>
  </nav>
  
  <!-- Hero Section -->
  <section class="py-5">
    <div class="container d-flex align-items-center justify-content-between flex-wrap">
      <div class="col-md-6">
        <h2 class="fw-bold" style="font-family: monospace; padding-bottom: 50px">
          Smart Learning<br>
          Deeper & More<br>
          <span style="color: red;">-AMAZING</span>
        </h2>
        <p class="text-muted">
          Unlock Vietnamese with fun, interactive lessons! Learn through real-life conversations,
          quizzes, and cultural insights. Start today and speak with confidence!
        </p>
        <button id="startLearning" class="btn btn-light border border-warning px-4 py-2 rounded-pill" title="Start Learning Now">
          Start Learning now
        </button>
      </div>
      <div class="col-md-5 position-relative mt-4 mt-md-0">
        <img src="img/happyStudent.png" alt="Happy Student" class="img-fluid">
        <!-- Có thể thêm icon ngôi sao nếu cần thiết -->
      </div>
    </div>
  </section>
  
  <div class="container">
    <p class="contentBetw">
        We are passionate about empowering leaders world wide with high quality,  
        <br>accessible education. Our mission is offering a diverse range of Vietnamese courses.
    </p>
  </div>

  <!-- Statistics Section -->
  <section class="py-4 bg-light">
    <div class="container d-flex justify-content-between text-center">
      <div class="stat-box">
        <h4>25+</h4><p>Years of Experiences</p>
      </div>
      <div class="stat-box">
        <h4>25+</h4><p>Years of Experience</p>
      </div>
      <div class="stat-box">
        <h4>25+</h4><p>Years of Students</p>
      </div>
    </div>
  </section>

  <!-- Courses Section -->
  <section class="py-5">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 id="exploreCourses">Explore Courses</h4>
        <div class="search-bar-container">
            <div class="search-bar">
                <div class="icon">
                    <img src="img/searchIcon.png" alt="Search Icon">
                </div>
                <input id="search" type="text" placeholder="Search Courses">
            </div>
        </div>
      </div>
      <div class="row g-4">
        <!-- Repeat course cards -->
        <div class="container my-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <!-- Course Card 1 -->
                <div class="col">
                    <div class="card">
                        <img src="img/travelIINVN.png" class="card-img-top" alt="Image 1">
                        <div class="card-body">
                            <h5 class="card-title">Traveling in Vietnam</h5>
                            <p class="card-text">Beginner - Vocabulary</p>
                        </div>
                    </div>
                </div>
                <!-- Course Card 2 -->
                <div class="col">
                    <div class="card">
                        <img src="img/travelIINVN.png" class="card-img-top" alt="Image 2">
                        <div class="card-body">
                            <h5 class="card-title">Traveling in Vietnam</h5>
                            <p class="card-text">Beginner - Vocabulary</p>
                        </div>
                    </div>
                </div>
                <!-- Course Card 3 -->
                <div class="col">
                    <div class="card">
                        <img src="img/travelIINVN.png" class="card-img-top" alt="Image 3">
                        <div class="card-body">
                            <h5 class="card-title">Traveling in Vietnam</h5>
                            <p class="card-text">Beginner - Vocabulary</p>
                        </div>
                    </div>
                </div>
                <!-- Course Card 4 -->
                <div class="col">
                    <div class="card">
                        <img src="img/travelIINVN.png" class="card-img-top" alt="Image 4">
                        <div class="card-body">
                            <h5 class="card-title">Traveling in Vietnam</h5>
                            <p class="card-text">Beginner - Vocabulary</p>
                        </div>
                    </div>
                </div>
                <!-- Course Card 5 -->
                <div class="col">
                    <div class="card">
                        <img src="img/travelIINVN.png" class="card-img-top" alt="Image 5">
                        <div class="card-body">
                            <h5 class="card-title">Traveling in Vietnam</h5>
                            <p class="card-text">Beginner - Vocabulary</p>
                        </div>
                    </div>
                </div>
                <!-- Course Card 6 -->
                <div class="col">
                    <div class="card">
                        <img src="img/travelIINVN.png" class="card-img-top" alt="Image 6">
                        <div class="card-body">
                            <h5 class="card-title">Traveling in Vietnam</h5>
                            <p class="card-text">Beginner - Vocabulary</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Add more cards as needed -->
      </div>
      <div class="text-center mt-4">
        <button type="button" id="browse-all-courses" class="btn btn-warning">Browse All Courses</button>
      </div>
    </div>
  </section>

  <!-- Take Test Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <img src="img/studentTakesBooks.png" class="img-fluid" alt="Subscribe" />
        </div>
        <div class="col-md-6 text-center text-md-start">
          <p id="phrase-taketest">
            Unlock Vietnamese with fun, interactive lessons! Learn through real-life conversations, quizzes, and cultural insights. Start today and speak with confidence!
          </p>
          <button type="button" class="btn btn-warning">Take test</button>
        </div>
      </div>
    </div>
  </section>
  

  <!-- What are you looking for -->
  <div class="container text-center my-5">
    <h1 class="title">What you looking for?</h1>
    <p class="text-muted">Unlock Vietnamese with fun, interactive lessons! Don’t wait anymore! Join now!</p>

    <div class="row justify-content-center mt-5 g-4">
      <div class="col-12 col-md-5">
        <div class="card card-custom bg-white card-spacing">
            <!-- Thay đổi thẻ img này bằng nội dung truyền vào -->
            <img class="slot1" src="img/card1_lookingfor.png" alt="">
        </div>
      </div>
      <div class="col-12 col-md-5">
        <div class="card card-custom bg-yellow card-spacing">
          <!-- Thay đổi thẻ img này bằng nội dung truyền vào -->
          <img class="slot2" src="img/card2_lookingfor.png" alt="">
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-light text-dark py-4">
    <div class="container">
      <div class="row">
        <!-- Cột đầu tiên chiếm 5 phần -->
        <div class="col-md-5 mb-4">
          <img id="logo-in-footer" src="img/logoFooter.png" alt="Logo Footer">
          <p id="text-in-footer">
            We're always finding out the best ways to help you master in learning Vietnamese!
          </p>
        </div>
  
        <!-- Cột thứ hai chiếm 7 phần và được chia 3 phần con -->
        <div class="col-md-7 mb-4">
          <div class="row">
            <!-- Phần con 1 -->
            <div class="col-md-4">
              <h5>Quick Links</h5>
              <ul class="list-unstyled">
                <li><a href="#" class="text-dark text-decoration-none">Test</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Courses</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Blog</a></li>
              </ul>
            </div>
            <!-- Phần con 2 -->
            <div class="col-md-4">
              <h5>Terms & Conditions</h5>
              <ul class="list-unstyled">
                <li><a href="#" class="text-dark text-decoration-none">Privacy</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Terms of Use</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Contact</a></li>
              </ul>
            </div>
            <!-- Phần con 3 -->
            <div class="col-md-4">
              <h5>Social Media</h5>
              <div class="social-grid">
                <a href="#" class="text-dark me-3"><i class="bi bi-envelope"></i></a>
                <a href="#" class="text-dark me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-dark me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-dark"><i class="bi bi-twitter-x"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
      
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>