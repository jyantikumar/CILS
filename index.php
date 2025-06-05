
<?php
session_start();
include 'connection.php'; //connect sa db

date_default_timezone_set('Asia/Manila');
 $currentDateTime = new DateTime();
$current_day =date("l");//"2025-04-06";//date("Y-m-d");
//echo $current_day; //"Today is " . $current_day . "<br>"; // Debugging: to check the current day
$current_date=date("Y-m-d");
//echo "Today is " . $current_date . "<br>"; // Debugging: to check the current day

// Query to fetch data
$sql = "SELECT DISTINCT start_time, end_time, course_code, faculty, status, start_date, end_date 
FROM create_sched 
WHERE (
    (repeat_sched IS NOT NULL 
        AND FIND_IN_SET('$current_day', repeat_sched) > 0 
        AND start_date <= '$current_date'  -- Event must have started or be on today
        AND end_date >= '$current_date'    -- Event must not have ended before today
    )
    OR 
    ( (repeat_sched IS NULL OR repeat_sched = '') 
        AND start_date = '$current_date'  -- Non-recurring event must match exactly today's date
    )
)
ORDER BY start_time ASC";



$result = $conn->query($sql); 

$ann_sql = "SELECT * FROM announcement_tbl 
            WHERE '$current_date' BETWEEN ann_start AND ann_end
            ORDER BY ann_id DESC";
$ann_result=$conn->query($ann_sql);


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
          </li>
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
          <div class="row my-5">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title text-center">Announcements</h3>
        <div id="announcementCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php if ($ann_result->num_rows > 0): ?>
              <?php $active = true; ?>
              <?php while ($ann_row = $ann_result->fetch_assoc()): ?>
                <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                <p class="card-text text-center">
    <b><?php echo htmlspecialchars($ann_row['ann_title']); ?></b> <?php echo htmlspecialchars($ann_row['ann_timestamp']); ?>
</p>


                  <p class="card-text text-center"><?php echo htmlspecialchars($ann_row['ann_content']); ?></p>                  
                </div>
                <?php $active = false; ?>
              <?php endwhile; ?>  
            <?php else: ?>
              <div class="carousel-item active" data-bs-interval="1000">
                <p class="card-text text-center">No announcements today.</p>
              </div>
            <?php endif; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#announcementCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="false"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#announcementCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="false"></span>
          </button>
        </div>
        <a href="create-announcement.php" class="btn float-end mt-2 ms-2" style="background-color: #3c6e7a; color: white;">Create</a>
        <a href="view_ann.php" class="btn float-end mt-2" style="background-color: #3c6e7a; color: white ;">View Announcements</a>

      </div>

    <!--  <a href="show-announcements.php" class="btn float-end mt-2" style="background-color: #3c6e7a; color: white;">Show all</a> !-->

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
<div class="row mb-4">
  <div class="col d-flex justify-content-end" style="margin-top:5px;">
    <a href="index-event.php" class="btn btn-warning">View Events</a>
  </div>
</div>
            <div class="row mb-5">
              <div style="margin-top:-20px;">
                <table class="table">
                  <thead class="table-info">
                    <tr>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Time</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Course Code</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Faculty Name</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      
                    <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                    <td><b><?php echo htmlspecialchars(date("h:i A", strtotime($row['start_time'])) . " - " . date("h:i A", strtotime($row['end_time']))); ?></b></td>
                                    <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                                    <td><?php echo htmlspecialchars($row['faculty']); ?></td>
                                   <td>
        <span class="badge 
          <?php
            switch ($row['status']) {
              case 'ONGOING': echo 'bg-success'; break;
              case 'DONE': echo 'bg-secondary'; break;
              case 'CANCELLED': echo 'bg-danger'; break;
              default: echo 'bg-info'; break; // UPCOMING or any other
            }
          ?>">
          <?php echo htmlspecialchars($row['status']); ?>
        </span>
      </td>
                               </tr>
                                <?php endwhile; ?>
                                
                                <?php else: ?>
                                <tr>
                                  <td colspan="6">No classes in the laboratory for today.</td>
                                </tr>
                              <?php endif; ?>    
                                </tr>
                 
                  </tbody>
                </table>          
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
// Function to update all status badges
// Function to update all status badges
function updateStatusBadges() {
    const badges = document.querySelectorAll('.status-badge');
    const now = new Date();
    
    badges.forEach(badge => {
        try {
            const startTime = new Date(badge.dataset.start);
            const endTime = new Date(badge.dataset.end);
            
            // Remove all status classes
            badge.classList.remove(
                'text-bg-success', 
                'text-bg-secondary', 
                'text-bg-primary', 
                'text-bg-danger'
            );
            
            // Determine current status
            if (now >= startTime && now <= endTime) {
                badge.textContent = 'ONGOING';
                badge.classList.add('text-bg-success');
            } else if (now > endTime) {
                badge.textContent = 'DONE';
                badge.classList.add('text-bg-secondary');
            } else if (now < startTime) {
                badge.textContent = 'UPCOMING';
                badge.classList.add('text-bg-primary');
            } else {
                badge.textContent = 'CANCELLED';
                badge.classList.add('text-bg-danger');
            }
        } catch (e) {
            console.error("Error updating badge:", e);
        }
    });
}

// Update immediately when page loads
updateStatusBadges();

// Update every second (1000 milliseconds)
const statusUpdateInterval = setInterval(updateStatusBadges, 1000);

// Also update when the tab becomes visible again
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        // Immediate update when tab becomes visible
        updateStatusBadges();
        // Reset the regular interval
        clearInterval(statusUpdateInterval);
        setInterval(updateStatusBadges, 1000);
    }
});

// Clean up interval when page unloads
window.addEventListener('beforeunload', function() {
    clearInterval(statusUpdateInterval);
});
    </script>

  </body>
</html>