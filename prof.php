<?php
session_start();
include 'connection.php'; //connect sa db
$email = $_SESSION['faculty_email'] ?? '';

if ($email) {
  
    $sql = "SELECT faculty_name FROM faculty_tbl WHERE faculty_email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
            $faculty_name = $row['faculty_name'];
}}
else{
  echo"<script>alert('User not logged in')
  window.location.href='login.php';</script>";
}
  if (isset($_POST['sched_id']) && isset($_POST['status'])) {
    $event_id = $_POST['sched_id'];
    $status = $_POST['status'];

    $sql = "UPDATE create_sched SET status='$status' WHERE sched_id=$event_id";
    $conn->query($sql);

    // Refresh the page immediately
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$result = $conn->query("SELECT * FROM create_sched");


date_default_timezone_set('Asia/Manila');
 $currentDateTime = new DateTime();
$current_day =date("l");//"2025-04-06";//date("Y-m-d");
//echo $current_day; //"Today is " . $current_day . "<br>"; // Debugging: to check the current day
$current_date=date("Y-m-d");
//echo "Today is " . $current_date . "<br>"; // Debugging: to check the current day


$sql = "SELECT DISTINCT sched_id, start_time, end_time, course_code, course_desc, faculty, status, start_date, end_date 
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
AND faculty = '$faculty_name' -- ------------------------------------------ DITO NAGSTOP  

ORDER BY start_time ASC";

$result = $conn->query($sql);

// Query to fetch announcements
$ann_sql = "SELECT * FROM announcement_tbl 
            WHERE '$current_date' BETWEEN ann_start AND ann_end
            ORDER BY ann_id DESC";
            
    $ann_result=$conn->query($ann_sql);

// Get the current time
$current_time = date('H:i:s'); // Current time in 24-hour format (HH:MM:SS)

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status']) && isset($_POST['sched_id'])) {
    $sched_id = $_POST['sched_id'];
    $new_status = $_POST['status'];

    // Update the status in the database
    $update_sql = "UPDATE create_sched SET status = ? WHERE sched_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $sched_id);
    
    if ($stmt->execute()) {
        echo "<script>
            alert('Status updated to " . $new_status . "');
            window.location.href = window.location.href;
        </script>";
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }
    $stmt->close();
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
            <h4>Welcome! <?php echo $faculty_name; ?></h4>
          <div class="row my-5">

            <div class="row mb-5">
              <div style="margin-top:-20px;">
  <table class="table">
      <thead class="table-info">
                    <tr>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Time</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Course Code</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Course Description</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Status</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;"></th>
                    </tr>

                  </thead>
        <?php
// Process status update BEFORE HTML renders
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']);
    $action = $_POST['action'];
    $status = ($action === 'in') ? 'ONGOING' : 'DONE';

    $sql = "UPDATE create_sched SET status = '$status' WHERE sched_id = $event_id";
    $result = mysqli_query($conn, $sql);

    // Optional: show error
    if (!$result) {
        echo "<script>alert('Failed to update status');</script>";
    }

    // Refresh the page after update
    echo "<script>window.location.href = window.location.href;</script>";
    exit();
}
?>

<tbody>
<?php if ($result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): 
    $sched_id = $row['sched_id'];
    $schedStatus = $row['status'];
    switch (strtoupper($schedStatus)) {
        case 'ONGOING': $statusClass = 'bg-success'; break;
        case 'DONE': $statusClass = 'bg-secondary'; break;
        case 'UPCOMING': $statusClass = 'bg-info'; break;
        case 'CANCELLED': $statusClass = 'bg-danger'; break;
        default: $statusClass = 'bg-light text-dark'; break;
    }
  ?>
  <tr>
    <td><b><?php echo date("h:i A", strtotime($row['start_time'])) . " - " . date("h:i A", strtotime($row['end_time'])); ?></b></td>
    <td><?php echo $row['course_code']; ?></td>
    <td><?php echo $row['course_desc']; ?></td>
    <td>
        <span class="badge <?php echo $statusClass; ?>"><?php echo $schedStatus; ?></span>
    </td>
    <td>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="event_id" value="<?php echo $row['sched_id']; ?>">
            <button type="submit" name="action" value="in" class="btn btn-success btn-sm">IN</button>
            <button type="submit" name="action" value="out" class="btn btn-danger btn-sm">OUT</button>
        </form>
    </td>
  </tr>
  <?php endwhile; ?>
<?php else: ?>
  <tr><td colspan="5">No schedules found.</td></tr>
<?php endif; ?>
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