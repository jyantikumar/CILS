<?php
include 'connection.php';

///////////////////////Get input
if (isset($_POST['create-sched'])){
  $purpose=strtoupper($_POST['purpose']);
  $sem=strtoupper($_POST['sem']);
  $program = strtoupper($_POST['program']);  
  $level=strtoupper($_POST['level']);
  $section =strtoupper($_POST['section']);
  $course_code = strtoupper($_POST['course_code']);  
  $course_desc =strtoupper( $_POST['course_desc']);
  $start_date =strtoupper($_POST['start_date']);  
  $end_date = strtoupper($_POST['end_date']);
  
    //////////////start time
  $start_time =strtoupper($_POST['start_time']); 
  $start12=date("h:i A", strtotime($start_time)); //////12 hours format na naka AM/PM
    //////////////end time
  $end_time = $_POST['end_time'];
  $end12=date("h:i A", strtotime($end_time));
  $faculty=strtoupper($_POST['faculty']);
  ///////////////selected days into arrays
  $days = isset($_POST['days']) ? $_POST['days'] : [];
  //////////////implode para maging string yung array
  $days_string = implode(",", $days);
  //////////// 
  $status="ONGOING";
  //////

foreach($days as $day){
  $sql = "INSERT INTO 
                create_sched (purpose, 
                              program,
                              sem,
                              program,
                              level, 
                              section, 
                              course_code,
                              course_desc,
                              start_time,
                              end_time,
                              start_date,
                              end_date,
                              repeat_sched,
                              faculty,
                              status) 
                  VALUES 
                          ('$purpose',
                            '$sem',
                            '$program',
                            '$level',
                            '$section',
                            '$course_code',
                            '$course_desc',
                            '$start12',
                            '$end12',
                            '$start_date',
                            '$end_date',
                            '$days_string',
                            '$faculty',
                            '$status')";

     if(mysqli_query($conn, $sql)) {
     }else{
      echo "error : " . mysqli_error($conn);
      break;
    }
}

header("location:view.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Schedule</title>
    <link rel="icon" type="image/x-icon" href="http://localhost/CILS/assets/Scitech logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
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
              <li class="sidebar-item">
                <a href="newSched.php" class="sidebar-link">Create Class</a>
              </li>
              <li class="sidebar-item">
                <a href="newEvent.php" class="sidebar-link">Create events</a>
              </li>
              <li class="sidebar-item">
                <a href="create-announcement.php" class="sidebar-link">Create announcements</a>
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
            <a href="create-announcement.php" class="sidebar-link">
              <i class="lni lni-pencil-alt"></i>
              <span>Create Announcement</span>
            </a>
          </li>
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
                  <a href="" class="nav-icon pe-md-0" data-bs-toggle="dropdown">
                    
                  </a>
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
                      <h3 class="card-title fw-semibold text-center mb-5">Create New Schedule</h3>
                      
                      <div class="row mx-5">
                        <div class="col-6 py-4">
                        <a href="newsched.php" class="text-decoration-none text-dark">

                        <!-- choos if for class or event !-->
                        <div class="card shadow-sm rounded-4" style="cursor: pointer;">
                            <div class="card-body">
                            <h5 class="card-title">Class</h5>
                            <p class="card-text">Lab scheduling for academic use.</p>                            </div>
                        </div>
                        </a>
                        </div><div class="col-6 py-4">
                     <a href="newevent.php" class="text-decoration-none text-dark">
                        <div class="card shadow-sm rounded-4" style="cursor: pointer;">
                            <div class="card-body">
                            <h5 class="card-title">Event</h5>
                            <p class="card-text">Lab scheduling for events.</p>
                            </div>
                        </div>
                        </a>
                        </div>

                        <form method="POST" action="">
                          
                    </form>
                  </div>
                </div>
              </div>
            </section>

            
            
          </main>
        </div>
      </div>

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