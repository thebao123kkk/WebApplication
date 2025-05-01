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
                <?php if (isset($_SESSION['user_id'])): ?>
                <span class="nav-link">Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php" class="btn rounded-pill me-2 px-4 py-1" style="background-color: #fff8d4; border: 1px solid black;">Đăng xuất</a>
                <?php else: ?>
                <button type="button" class="btn rounded-pill me-2 px-4 py-1" style="background-color: #fff8d4; border: 1px solid black;" data-bs-toggle="modal" data-bs-target="#signinModal">Log in</button>
                <button type="button" class="btn rounded-pill px-4 py-1" style="background-color: #fff8d4; border: 1px solid #f58e42;" data-bs-toggle="modal" data-bs-target="#signupModal">Sign up</button>
                <?php endif; ?>
            </li>
            </ul>
        </div>
        </div>
    </nav>

    <!-- Sign In Modal -->
    <div class="modal fade" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="signinModalLabel">Đăng nhập</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php if (isset($signin_error)): ?>
                <div class="alert alert-danger"><?php echo $signin_error; ?></div>
            <?php endif; ?>
            <form method="POST" action="home.php">
                <div class="mb-3">
                <label for="signinEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="signinEmail" name="email" required>
                </div>
                <div class="mb-3">
                <label for="signinPassword" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="signinPassword" name="password" required>
                </div>
                <button type="submit" name="signin" class="btn btn-primary">Đăng nhập</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="signupModalLabel">Đăng ký</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php if (isset($signup_success)): ?>
                <div class="alert alert-success"><?php echo $signup_success; ?></div>
            <?php elseif (isset($signup_error)): ?>
                <div class="alert alert-danger"><?php echo $signup_error; ?></div>
            <?php endif; ?>
            <form method="POST" action="home.php">
                <div class="mb-3">
                <label for="signupUsername" class="form-label">Tên người dùng</label>
                <input type="text" class="form-control" id="signupUsername" name="username" required>
                </div>
                <div class="mb-3">
                <label for="signupEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="signupEmail" name="email" required>
                </div>
                <div class="mb-3">
                <label for="signupPassword" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="signupPassword" name="password" required>
                </div>
                <button type="submit" name="signup" class="btn btn-primary">Đăng ký</button>
            </form>
            </div>
        </div>
        </div>
    </div>

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
        <h1 class="title">What you looking for?</h1esteem1" href="#" class="text-dark text-decoration-none">Privacy</a>
        <a href="#" class="text-dark text-decoration-none">Terms</a>
        <a href="#" class="text-dark text-decoration-none">Contact</a>
    </div>
    <div>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="FB"></a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733579.png" alt="IG"></a>
    </div>
</footer>
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>