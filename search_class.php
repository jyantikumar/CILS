<?php

include 'connection.php';
date_default_timezone_set('Asia/Manila'); // Set timezone (optional but good)
$currentDateTime = new DateTime(); // Create the current time
$result=null;

if (isset($_GET['search_date'])) {
    $searchDate = $_GET['search_date'];

    $sql = "SELECT * FROM create_sched WHERE start_date = '$searchDate'";
    $result = $conn->query($sql);

}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CS/IT Laboratory Scheduler</title>
    <link rel="icon" type="image/x-icon" href="http://localhost/CILS/assets/Scitech logo.png" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!-- <link rel="stylesheet" href="sidebars.css"> -->
    <!-- <link rel="stylesheet" href="sidebars.js"> -->

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta http-equiv="refresh" content="20;url=view.php">

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
          <li class="sidebar-item active">
            <a href="#" class="sidebar-link">
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
          </div>
        </nav>
        <main class="content px-3 py-4">

          <section id="dashboard" class="mx-4 pb-0" style="font-family: 'Montserrat';">
          <div class="row mb-5">
                <div class="col">
                  <table class="table">
                    <thead class="table-info">
                      <tr>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Time</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Date</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Section</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Course Code</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Faculty Name</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Status</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;"></th>

                    </tr>
                    </thead>
                    <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><b><?php echo htmlspecialchars(date("h:i A", strtotime($row['start_time'])) . " - " . date("h:i A", strtotime($row['end_time']))); ?></b></td>
            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
            <td><?php echo htmlspecialchars($row['section']); ?></td>
            <td><?php echo htmlspecialchars($row['course_code']); ?></td>
            <td><?php echo htmlspecialchars($row['faculty']); ?></td>
            <td>
                <?php
                $schedDate = $row['start_date'];
                $schedStart = $row['start_time'];
                $schedEnd = $row['end_time'];

                $schedStartDateTime = new DateTime("$schedDate $schedStart");
                $schedEndDateTime = new DateTime("$schedDate $schedEnd");

                if ($currentDateTime >= $schedStartDateTime && $currentDateTime <= $schedEndDateTime) {
                    echo '<span class="badge text-bg-success">ONGOING</span>';
                } elseif ($currentDateTime > $schedEndDateTime) {
                    echo '<span class="badge text-bg-secondary">DONE</span>';
                } elseif ($currentDateTime < $schedStartDateTime) {
                    echo '<span class="badge text-bg-primary">UPCOMING</span>';
                } else {
                    echo '<span class="badge text-bg-danger">CANCELLED</span>';
                }
                ?>
            </td>
            <td>
                <a href="edit.php?sched_id=<?php echo $row['sched_id']; ?>" class="btn btn-warning">Edit</a>
                <a href="delete_sched.php?sched_id=<?php echo $row['sched_id']; ?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="text-center">No schedules found for this date.</td>
    </tr>
<?php endif; ?>

                    </tbody>
                  </table>
                    <tbody>

    </div>
  </div>

<!--  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-center">Create New Schedule</h5>
        <p class="card-text fs-6 text-center text-secondary">Simplify your scheduling with automated tools to streamline class management.</p>
        <a href="purpose.php" class="btn float-end" style="background-color: #3c6e7a; color: white;">Create Schedule</a>
      </div>
    </div>
  </div> !-->
</div>
</section>
          
      

          </main>
        </div>
      </div>
      
      
  
      
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
  
      <!-- Javascript Bootstrap -->
      <script src="sidebars.js"></script>
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