<?php
include 'connection.php';

if(isset($_POST['add-course'])){

$program=strtoupper($_POST['program']);
$sem=strtoupper($_POST['sem']);
$level=strtoupper($_POST['level']);
$course_code=strtoupper($_POST['course_code']);
$course_desc=strtoupper($_POST['course_desc']);

if($program=="INFORMTION TECHNOLOGY"){
     $table="it";
}
else{
    $table='cs';
}
    $sql="Select * from $table where course_desc='$course_desc'";
    $result=$conn->query($sql);

if (mysqli_num_rows($result) > 0) {//if may existing course sa table
            echo "<script>alert('Course already exists');</script>";
} else{
        $table="cs";
    }
 $insert="insert into $table (course_code, course_desc, level, semester)  values ('$course_code','$course_desc','$level','$sem')";
 $insertQuery=$conn->query($insert);
 header("location:view_courses.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Schedule</title>
    <style>
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="http://localhost/CILS/assets/Scitech logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
    <!-- <link rel="stylesheet" href="newsched.css"> -->
    <!-- <link rel="stylesheet" href="sidebars.js"> -->

    <!-- CSS Bootstrap -->
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
              <li class="sidebar-item active">
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
     <!--
          <li class="sidebar-item">
            <a href="create-announcement.php" class="sidebar-link">
              <i class="lni lni-pencil-alt"></i>
              <span>Create Announcement</span>
            </a>
          </li> !-->
          <!--<li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#courses" aria-expanded="false" aria-control="course">
            <i class="bi bi-journal-plus"></i>              
            <span>Curriculum</span>
            </a>
            <ul class="sudebar-dropdown list-unstyled collapse" id="courses" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a href="add_courses.php" class="sidebar-link">Add Courses</a>
              </li>
              <li class="sidebar-item">
                <a href="add_courses.php" class="sidebar-link">View Curriculum</a>
              </li>
            </ul>
          </li> !-->

            <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#course" aria-expanded="false" aria-controls="course">
<i class="lni lni-book"></i>        <span>Curriculum</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled collapse" id="course" data-bs-parent="#sidebar">
              <li class="sidebar-item active">
                <a href="add_courses.php" class="sidebar-link">Add Courses</a>
              </li>
              <li class="sidebar-item">
                <a href="view_courses.php" class="sidebar-link">View Curriculum</a>
              </li>
    </ul> 
          <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
              <i class="lni lni-users"></i>
              <span>Faculty Panel</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled collapse" id="auth" data-bs-parent="#sidebar">
              <li class="sidebar-item">
                <a href="faculty-management-edit.php" class="sidebar-link">Add Faculty</a>
              </li>
              <li class="sidebar-item">
                <a href="faculty-management.php" class="sidebar-link">View Faculty</a>
              </li>
              <li class="sidebar-item">
                <a href="archive_faculty.php" class="sidebar-link">Faculty Archive</a>
              </li>
    </ul>
          </li>
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
              <a class="navbar-brand mx-3 fs-3" id="navtitle" href="#" >CS/IT Laboratory Scheduler</a>
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
                    
                  </a>
                  <div class="dropdown-menu dropdown-menu-end rounded">
                    <a href="" class="dropdown-item">
                      <span>Analytics</span>
                    </a>
                    <a href="" class="dropdown-item">
                      <span>Analytics</span>
                    </a>
                    <div class="dropdown-divider">
                      <a href="" class="dropdown-item">
  
                      </a>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </nav>

          <main class="content px-3 py-4 ">
            <section class="mx-5">
              <div class="row my-5">
                <div class="col-sm-12">
                  <div class="card">
                    <div class="card-body">
                      <h3 class="card-title fw-semibold text-center mb-5">Add New Course</h3>


                      <form action="" method="POST">
                      <div class="row mx-5">
                     
                    <div class="col-4 pb-4">
                          <label for="time" class="form-label">Input Program</label>
                          <select class="form-select" id="program" aria-label="Default select example" name="program" required>
                                  <option selected>Choose...</option>
                                  <option value="COMPUTER SCIENCE">COMPUTER SCIENCE</option>
                                  <option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
                         </select>                      
                         </div>
                      <div class="col-4 pb-4">
                          <label for="semester" class="form-label">Semester</label>
                          <select class="form-select" id="semester" name="sem" required>
                          <option selected>Choose...</option>
                              <option value="First Semester">FIRST SEMESTER</option>
                              <option value="Second Semester">SECOND SEMESTER</option>
                              <option value="SUMMER CLASSES">SUMMER CLASSES</option>
                          </select>
                      </div>
                        

                              <div class="col-4 pb-4">
                                <label for="time" class="form-label">Year Level</label>
                                <select class="form-select" id="year_level" aria-label="Default select example" name="level"required>
                                  <option selected>Choose...</option>
                                  <option value="FIRST YEAR">FIRST YEAR</option>
                                  <option value="SECOND YEAR">SECOND YEAR</option>
                                  <option value="THIRD YEAR">THIRD YEAR</option>
                                  <option value="FOURTH YEAR">FOURTH YEAR</option>
                                </select>
                              </div>
                              <div class="col-6 pb-4">
                        <label for="time" class="form-label">Course</label>
                        <input type="text" id="course_desc" class="form-control" name="course_desc" placeholder="Enter course"required ></input>
                    </div> 
                    <div class="col-6 pb-4">
                        <label for="time" class="form-label">Course Code</label>
                        <input type="text" id="course_code" class="form-control" name="course_code" placeholder="Enter course code"required ></input>
                    </div> 
                    
                            
                      </div>
                      <button type="submit" class="btn float-end" style="background-color: #3c6e7a; color: white;" name="add-course">Add Course</button>

                      </div>
                      
                      </div>
                    </form>
                  <?php  
                  /*
                  <?php if ($error_message): ?>
                        <div class="error"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                  */?>
                  </div>
                </div>
              </div>
            </section>

            
            
          </main>
        </div>
      </div>

      <script src="script.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
$(document).ready(function() {
    function updateDate() {
        const currentDateElement = document.getElementById('currentDate');
        if (currentDateElement) { // Check if element exists
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            currentDateElement.textContent = now.toLocaleDateString('en-US', options);
        }
    }

    function updateTime() {
        const localTimeElement = document.getElementById('localTime');
        if (localTimeElement) { // Check if element exists
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            
            hours = hours % 12;
            hours = hours ? hours : 12; // Convert 0 to 12
            
            // Add leading zeros
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            
            localTimeElement.textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
        }
    }

    updateDate();
    updateTime();
    
    // Update every second
    setInterval(function() {
        updateDate();
        updateTime();
    }, 1000);
});
</script>
</body>
</html>