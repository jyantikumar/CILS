      <?php
      include 'connection.php';
      //session_start();

if (isset($_POST['add_faculty'])) {
        $faculty_name = strtoupper(trim($_POST['faculty_name']));
        $faculty_email =strtoupper(trim($_POST['faculty_email']));
          $faculty_pass=trim($_POST['faculty_pass']);
$faculty_status="ACTIVE" ;

$userSQL="Select * from faculty_tbl where faculty_email='$faculty_email'";
$userResult=$conn->query($userSQL);
if (mysqli_num_rows($userResult) > 0) {
echo "<script>alert('User already exists')</script>";
}else{
      if(strlen($faculty_pass)<8){
        echo "<script>alert('Password must be 8 or more characters long')</script>";
      }else{
         $sql = "INSERT INTO faculty_tbl (faculty_name, faculty_email, faculty_pass, faculty_status) 
VALUES ('$faculty_name','$faculty_email', '$faculty_pass', '$faculty_status')";

          if(mysqli_query($conn, $sql)) {
            header("location:faculty-management.php");
            echo "faculty added successfully";
          }
          else{
          echo "error : " . mysqli_error($conn);
          }
      }
      }
    }

      ?>
      <!doctype html>
      <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>CS/IT Laboratory Scheduler</title>
          <link rel="icon" type="image/x-icon" href="http://localhost/CILS/assets/Scitech logo.png" />   

          <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
          <link rel="stylesheet" href="styles.css">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        </head>
        <body>

          <div class="wrapper">
            <aside id="sidebar">
              <div class="d-flex">
                <button class="toggle-btn" type="button">
                  <i class="lni lni-grid-alt"></i>
                </button>
                  <div class="sidebar-logo" style="margin-top: 32px;">
                    <a href="#">Dashboard</a>
                  </div>
              </div>
              <ul class="sidebar-nav">
                <li class="sidebar-item">
                  <a href="index.php" class="sidebar-link">
                    <i class="lni lni-home"></i>
                    <span>Home</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#createDropdown" aria-expanded="false" aria-controls="auth">
                  <i class="lni lni-add-files"></i>
                      <span>Create</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="createDropdown" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                      <a href="newSched.php" class="sidebar-link">Add Class</a>
                    </li>
                    <li class="sidebar-item">
                      <a href="newEvent.php" class="sidebar-link">Add events</a>
                    </li>
                    <li class="sidebar-item">
                      <a href="create-announcement.php" class="sidebar-link">Add announcements</a>
                    </li>
                  </ul>
                </li>
                  <li class="sidebar-item">
                  <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#viewDropdown" aria-expanded="false" aria-controls="auth">
                <i class="lni lni-eye"></i>
                    <span>View</span>
                  </a>
                  <ul class="sidebar-dropdown list-unstyled collapse" id="viewDropdown" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                      <a href="view.php" class="sidebar-link">View classes</a>
                    </li>
                    <li class="sidebar-item">
                      <a href="view_event.php" class="sidebar-link">View events</a>
                    </li>
                    <li class="sidebar-item">
                    <a href="view_ann.php" class="sidebar-link">View announcements</a>
                    </li>
                  </ul>
                </li>
                                <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#course" aria-expanded="false" aria-controls="course">
<i class="lni lni-book"></i>        <span>Curriculum</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled collapse" id="course" data-bs-parent="#sidebar">
              <li class="sidebar-item">
                <a href="add_courses.php" class="sidebar-link">Add Courses</a>
              </li>
              <li class="sidebar-item active">
                <a href="view_courses.php" class="sidebar-link">View Curriculum</a>
              </li>
</ul>
              <!--
                <li class="sidebar-item">
                  <a href="create-announcement.php" class="sidebar-link">
                    <i class="lni lni-pencil-alt"></i>
                    <span>Create Announcement</span>
                  </a>
                </li> !-->
                <!-- <li class="sidebar-item">
                  <a href="#" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span>Faculty Management</span>
                  </a>
                </li> -->
                <li class="sidebar-item">
                  <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-users"></i>
                    <span>Faculty Panel</span>
                  </a>
                  <ul class="sidebar-dropdown list-unstyled collapse" id="auth" data-bs-parent="#sidebar">
                    <li class="sidebar-item active">
                      <a href="faculty-management-edit.php" class="sidebar-link">Add Faculty</a>
                    </li>
                    <li class="sidebar-item ">
                      <a href="faculty-management.php" class="sidebar-link">View Faculty</a>
                    </li>
                    <li class="sidebar-item">
                      <a href="archive_faculty.php" class="sidebar-link">Faculty Archive</a>
                    </li>
                  </ul>
                   <li class="sidebar-item">
                <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#acc" aria-expanded="false" aria-controls="auth">
              <i class="lni lni-user"></i>
              <span>Users Management</span>
                </a>
              <ul class="sidebar-dropdown list-unstyled collapse" id="acc" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="add_users.php" class="sidebar-link">Add User</a>
                  </li>
                  <li class="sidebar-item">
                    <a href="view_users.php" class="sidebar-link">View Users</a>
                  </li>
            </ul> 
                </li>

                    <!--<li class="sidebar-item">
                  <a href="conflict.php" class="sidebar-link">
                    <i class="lni lni-popup"></i>
                    <span>Conflict Alerts</span>
                  </a>
                </li> !-->

                <li class="sidebar-footer">
                  <a href="logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                  </a>
                </li>
              </ul>
            </aside>
            <div class="main">
              <nav class="navbar navbar-expand  px-4 py-4" data-bs-theme="dark">
                <div class="navbar-collapse collapse">

                  <img src="assets/scitech logo.png"  alt="Scitechlogo" height="60px" width="60px">
                  <a class="navbar-brand mx-3 fs-3" id="navtitle" href="#" style="text-shadow: 4px 4px 5px rgba(14, 14, 14, 0.6) !important;">CS/IT Laboratory Scheduler</a>
                  <ul class="navbar-nav ms-auto">
                    <li class="navbar-item dropdown">
                      <a href="" class="nav-icon pe-md-0" data-bs-toggle="dropdown"></a>
                    </li>
                  </ul>
                </div>
                <ul class="navbar-nav ms-auto">
                    <li class="navbar-item dropdown">
                      <div class="timer-container">
                        <!-- Current Date -->
                        <div class="date" id="currentDate">
                          <!-- Date will be dynamically inserted here -->
                        </div>
                    
                        <!-- Local Time -->
                        <div class="time" id="localTime">
                          00:00:00
                        </div>
                      </div>
                    </li>
                  </ul>
              </nav>
              <main class="content px-3 py-4">
                <!-- Faculty Management Form -->
                <div class="faculty-management-wrapper">
                  <h2>Faculty Management</h2>

                  <div class="faculty-form">
                    <form method="POST">

                    <div class="row">
                            <div class="col-6 pb-4">
                        <label for="facultyName" class="form-label">Faculty Name</label>
                        <input type="text" class="form-control" id="facultyName" name="faculty_name" required>
                        <div class="invalid-feedback">Please provide a faculty name.</div>
                      </div>
                      
                            <div class="col-6 pb-4">
                        <label for="facultyEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="facultyEmail" name="faculty_email" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                      </div>
                                            </div>

                  <div class="row">
                            <div class="col-12 pb-4">
                                <label for="facultyPass" class="form-label">Enter password</label>
                                <input type="password" class="form-control" id="faculty_pass" name="faculty_pass" required>
                            </div>
                        
            <button type="submit" class="btn" style="background-color: #3c6e7a; color: white;" name="add_faculty">Add Faculty</button>
                    </form>
                  </div>
      </div>
                  <center>
                    <a href="faculty-management.php">
                  <button type="submit" class="btn" style="background-color: #3c6e7a; color: white;">View List</button>
                </a>
                </center>

              </main>
      <!-- Bootstrap JS (Optional, but required for responsive navbar) -->
      <script src="script.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <script>
            // Function to update the current date
          function updateDate() {
            const currentDateElement = document.getElementById('currentDate');
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
            const formattedDate = now.toLocaleDateString('en-US', options);
            currentDateElement.textContent = formattedDate;
          }

          // Function to update the local time (12-hour format)
          function updateTime() {
            const localTimeElement = document.getElementById('localTime');
            const now = new Date();
            
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            let ampm = hours >= 12 ? 'PM' : 'AM';

            // Convert 24-hour format to 12-hour format
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            
            // Format minutes and seconds to always have two digits
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            // Update the time display in 12-hour format
            localTimeElement.textContent = hours + ":" + minutes + ":" + seconds + " " + ampm;
          }

          // Update the date and time every second
          setInterval(function() {
            updateDate();
            updateTime();
          }, 1000);
          </script>
      </body>
      </html>