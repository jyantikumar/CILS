
<?php
include 'connection.php';
session_start();
date_default_timezone_set('Asia/Manila');

// Get logged-in faculty email from session
$email = $_SESSION['faculty_email'] ?? '';

// Initialize variables
$faculty_name = '';
$currentDateTime = new DateTime();
$current_date = $currentDateTime->format('Y-m-d');
$current_day = $currentDateTime->format('l'); // Full day name (e.g. Monday)

// Step 1: Get faculty name using session email
if ($email) {
    $prof = "SELECT faculty_name FROM faculty_tbl WHERE faculty_email = '$email'";
    $profresult = $conn->query($prof);
    if ($profresult && $profresult->num_rows > 0) {
        $row = $profresult->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    }
}

// Step 2: If faculty name is found, run paginated query for that professor
if ($faculty_name) {
    $limit = 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Get total schedules for pagination
    $total_sql = "SELECT COUNT(*) as total FROM create_sched WHERE faculty = '$faculty_name'";
    $total_result = mysqli_query($conn, $total_sql);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_schedules = $total_row['total'];
    $total_pages = ceil($total_schedules / $limit);

    // Get paginated schedules
    $sql = "SELECT * FROM create_sched WHERE faculty = '$faculty_name' ORDER BY start_date, start_time LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    // Optional: Get today's schedules (both recurring and one-time)
    $subs = "SELECT DISTINCT sched_id, start_time, end_time, course_code, course_desc, faculty, status, start_date, end_date 
    FROM create_sched 
    WHERE (
        (repeat_sched IS NOT NULL 
            AND FIND_IN_SET('$current_day', repeat_sched) > 0 
            AND start_date <= '$current_date' 
            AND end_date >= '$current_date'
        )
        OR 
        ((repeat_sched IS NULL OR repeat_sched = '') 
            AND start_date = '$current_date'
        )
    )
    AND faculty = '$faculty_name'
    ORDER BY start_time ASC";

    $subresult = $conn->query($subs);
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
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!-- <link rel="stylesheet" href="sidebars.css"> -->
    <!-- <link rel="stylesheet" href="sidebars.js"> -->

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
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
          <li class="sidebar-item ">
            <a href="prof.php" class="sidebar-link">
              <i class="lni lni-home"></i>
              <span>Home</span>
            </a>
          </li>
           <li class="sidebar-item active">
            <a href="view_own.php" class="sidebar-link">
          <i class="lni lni-eye"></i>
              <span>View Classes</span>
            </a>
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

            <div class="container" style="max-width: 1920px;">
              <h1 class="text-center my-5">View Schedule</h1>
              <div class="input-group" style="max-width: 400px;">


              <br>
              
            </div>

            
              <div class="row mb-5">
                <div class="col">
                  <?php
                  echo '<nav aria-label="Schedule pagination">';
echo '<ul class="pagination justify-content-center">';

// Previous button
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
} else {
    echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
}

// Page numbers
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    }
}

// Next button
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
} else {
    echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
}

echo '</ul>';
echo '</nav>';

                  ?>
                  <table class="table">
                    <thead class="table-info">
                      <tr>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Date</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Time</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Section</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Code</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Description</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Faculty Name</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Status</th>

                      </tr>
                    </thead>
                    <tbody>
                    <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                                    <td><b><?php echo htmlspecialchars(date("h:i A", strtotime($row['start_time'])) . " - " . date("h:i A", strtotime($row['end_time']))); ?></b></td>

                                    <td><?php echo htmlspecialchars($row['section']); ?></td>
                                    <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                                    <td><?php echo htmlspecialchars($row['course_desc']); ?></td>

                                    <td><?php echo htmlspecialchars($row['faculty']); ?></td>

                                    <TD>
                          <?php 
                                      $schedDate = $row['start_date'];
                                      $schedStart = $row['start_time'];
                                      $schedEnd = $row['end_time'];
                                      
                                      // Create DateTime objects for this specific schedule
                                      $schedStartDateTime = new DateTime("$schedDate $schedStart");
                                      $schedEndDateTime = new DateTime("$schedDate $schedEnd");
                                      
                                      // Format for JavaScript (ISO 8601 format)
                                      $startISO = $schedStartDateTime->format('c');
                                      $endISO = $schedEndDateTime->format('c');
                                      ?>
<span class="badge 
              <?php
                switch ($row['status']) {
                  case 'ONGOING': echo 'bg-success'; break;
                  case 'DONE': echo 'bg-secondary'; break;
                  case 'CANCELLED': echo 'bg-danger'; break;
                  default: echo 'bg-info'; break; // UPCOMING or other
                }
              ?>">
              <?php echo htmlspecialchars($row['status']); ?>
            </span>
          </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php endif; ?>     
                    </tbody>
                  </table>
                </div>
              </div>
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
    </script>

  </body>
</html>