<?php
// Lấy điểm số từ tham số URL
if (isset($_GET['score'])) {
    $score = $_GET['score'];
} else {
    $score = 0; // Nếu không có điểm, mặc định là 0
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Result | VHuB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style4Result.css">
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
            <button id="sign-in" class="btn rounded-pill me-2 px-4 py-1" style="background-color: #fff8d4; border: 1px solid black;">Log in</button>
            <button id="sign-up" class="btn rounded-pill px-4 py-1" style="background-color: #fff8d4; border: 1px solid #f58e42;">Sign up</button>
          </li>
        </ul>
        
      </div>
    </div>
  </nav>

  <!-- Main Content (Test Result Section) -->
  <section class="container my-5">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6 col-lg-6">
        <div class="image-box">
          <img src="img/result.jpg" alt="Great Job" class="img-fluid custom-image">
        </div>
      </div>
      <div class="col-md-6 col-lg-6 m-lg-0">
        <h1 class="fw-bold">Here's your test result!</h1>
        <h2 class="my-3">
          <?php echo "$score/20"; ?>
        </h2>

        <p class="lead" style="max-width:430px">
          Whether you're a beginner or looking to improve your Vietnamese skills, we provide easy-to-follow lessons, interactive exercises, and practical vocabulary to help you learn effectively.
        </p>
        <button class="btn rounded-pill px-4 py-2 mt-3" style="background-color: #fff8d4; width:250px" onclick="window.location.href='takingTest.php';">
          Take Test Again
        </button>
      </div>
    </div>
  </section>
  
  
  <footer class="bg-light text-dark py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-5 mb-4">
          <img id="logo-in-footer" src="img/logoFooter.png" alt="Logo Footer">
          <p id="text-in-footer">
            We're always finding out the best ways to help you master in learning Vietnamese!
          </p>
        </div>
        <div class="col-md-7 mb-4">
          <div class="row">
            <div class="col-md-4">
              <h5>Quick Links</h5>
              <ul class="list-unstyled">
                <li><a href="#" class="text-dark text-decoration-none">Test</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Courses</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Blog</a></li>
              </ul>
            </div>
            <div class="col-md-4">
              <h5>Terms & Conditions</h5>
              <ul class="list-unstyled">
                <li><a href="#" class="text-dark text-decoration-none">Privacy</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Terms of Use</a></li>
                <li><a href="#" class="text-dark text-decoration-none">Contact</a></li>
              </ul>
            </div>
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
