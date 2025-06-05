<?php
include 'connection.php';
session_start();

if (isset($_POST['login'])) {
  $email = strtoupper($_POST['userEmail']);
  $password = trim($_POST['userPassword']);

  //echo "Email: $email <br> Password: $pw <br>";

  $query = "SELECT * FROM users WHERE userEmail='$email' AND userPassword='$password'";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);

      $_SESSION['userEmail']=$row['userEmail'];
      header('location:index.php');
      exit();
    } 
    else {
$Aquery = "SELECT * FROM faculty_tbl WHERE faculty_email='$email' AND faculty_pass='$password' AND faculty_status='ACTIVE'";   
 $Aresult = mysqli_query($conn, $Aquery);

    if (mysqli_num_rows($Aresult) > 0) {
      $row = mysqli_fetch_assoc($Aresult);
      $_SESSION['faculty_email'] = $row['faculty_email'];
      header('location:prof.php');
      exit();
    } else {
      echo "<script>alert('Invalid username or password');</script>";
    }
}}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CS/IT Laboratory E-Scheduler</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="login.css" rel="stylesheet">

  <style>
body, html {
  height: 100%;
  margin: 0;
}

.overlay-bg {
  position: relative;
  background-image: url('LRC_Lab.png'); /* Replace with your image path */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 100vh;
  width: 100%;
}

.overlay-bg::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  z-index: 1;
    background:rgba(49, 79, 87, 0.86);
}

.login-container {
  position: relative;
  z-index: 2; /* Ensures form stays above the overlay */
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.login-form {
  width: 100%;
  max-width: 400px;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.95);
  border-radius: 0.375rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

  </style>
</head>
<body>
<div class="overlay-bg">
<div class="container-fluid login-container">

  <div class="container-fluid login-container">
    <div class="row justify-content-center w-100">
      <div class="col-md-8 col-lg-6 col-xl-4">
        <form class="login-form" action="" method="POST">
          <p class="form-title text-center mb-4">CS/IT Laboratory E-Scheduler</p>
          
          <div class="input-container mb-3">
            <div class="input-group">
              <input class="form-control form-control-lg" placeholder="Enter email" type="email" name="userEmail">
            </div>
          </div>
          
          <div class="input-container mb-4">
            <div class="input-group">
              <input class="form-control form-control-lg" placeholder="Enter password" type="password" name="userPassword">
            </div>
          </div>
          
          <div class="d-grid mb-3">
            <button class="btn btn-primary btn-lg" style="background:#5397a8;" type="submit" name="login">Sign in</button>
          </div>
          
          <p class="text-center text-muted" id="info-form">
            This page is for the faculty of Manila Central University only.<br>
            Please exit the page if <a href="student-view.php">otherwise.</a>
          </p>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</DIV>
</DIV>
</body>
</html>