<?php
include 'connection.php'; //connect sa db

date_default_timezone_set('Asia/Manila');
 $currentDateTime = new DateTime();
$current_day =date("l");//"2025-04-06";//date("Y-m-d");
//echo $current_day; //"Today is " . $current_day . "<br>"; // Debugging: to check the current day
$current_date=date("Y-m-d");
//echo "Today is " . $current_date . "<br>"; // Debugging: to check the current day


$sql = "SELECT DISTINCT start_time, end_time, course_code, course_desc, faculty, status, start_date, end_date 
FROM create_sched 
WHERE (
    (repeat_sched IS NOT NULL 
        AND FIND_IN_SET('$current_day', repeat_sched) > 0 
        AND start_date <= '$current_date'  -- Event must have started on today
        AND end_date >= '$current_date'    -- Event must not have ended before today
    )
    OR 
    ( (repeat_sched IS NULL OR repeat_sched = '') 
        AND start_date = '$current_date'  -- Non-recurring event must match exactly today's date
    )
)
ORDER BY start_time ASC";

$result = $conn->query($sql);

// Query to fetch announcements
$ann_sql = "SELECT * FROM announcement_tbl 
            WHERE '$current_date' BETWEEN ann_start AND ann_end
            ORDER BY ann_id DESC";
            
    $ann_result=$conn->query($ann_sql);

// Get the current time
$current_time = date('H:i:s'); // Current time in 24-hour format (HH:MM:SS)
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
  <body>

    <div class="wrapper">
      
      <div class="main">
        <nav class="navbar navbar-expand  px-4 py-4" data-bs-theme="dark">
          <div class="navbar-collapse collapse">
            <img src="assets/scitech logo.png"  alt="Scitechlogo" height="60px" width="60px">
            <a class="navbar-brand mx-3 fs-3" id="navtitle" href="#" style="text-shadow: 4px 4px 5px rgba(14, 14, 14, 0.6) !important;">CS/IT Laboratory Scheduler</a>
            <ul class="navbar-nav ms-auto">
              <li class="navbar-item dropdown">
                <div class="timer-container">
                  <!-- Current Date -->
                  <div class="date fs-5 me-5" id="currentDate">
                    <!-- Date will be dynamically inserted here -->
                  </div>
              
                  <!-- Local Time -->
                  <div class="time fs-4" id="localTime">
                    00:00:00
                  </div>
                </div>
              </li>
            </ul>
            <!-- <a href="html/login.php" class="btn btn-brand mt-20 ms-3 fw-bold" id="login">LOGIN</a> -->
            <button 
  type="button" 
  class="btn fw-bold" 
  style="color: #fdaf07;" 
  onclick="window.location.href='login.php';"
>
  LOGIN
</button>


            <!-- Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-light" id="loginModalLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="username" class="form-label text-light ms-1">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="mb-3">
              
              <label for="password" class="form-label text-light ms-1">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Enter password">
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input " id="rememberMe">
              <label class="form-check-label text-light" for="rememberMe">Remember me</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>
    </div>
  </div>
          </div>
        </nav>
        <main class="content px-3 py-4">

          <section id="dashboard" class="mx-4 pb-0" style="font-family: 'Montserrat';">

          <div class="row my-12 align-items-stretch">
  <!-- Announcements Card -->
  <div class="col-sm-6 mb-3 mb-sm-0">
    <div class="card h-100">
      <div class="card-header text-center fs-3" style="background-color: #3c6e7a; color: white;">
        Announcements
      </div>
      <div class="card-body d-flex flex-column">
        <div id="announcementCarousel" class="carousel slide flex-grow-1" data-bs-ride="carousel">
          <div class="carousel-inner h-100">
            <?php 
            if ($ann_result->num_rows > 0):
              $active = true;
              while ($row = $ann_result->fetch_assoc()): 
            ?>
              <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                <div class="d-flex justify-content-center align-items-center p-3 h-100">
                  <p class="text-center"><?php echo htmlspecialchars($row['ann_content']); ?></p>
                </div>
              </div>
            <?php 
              $active = false;
              endwhile;
            else:
            ?>
              <div class="carousel-item active">
                <div class="d-flex justify-content-center align-items-center h-100 p-3">
                  <p class="text-center">No announcements available</p>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <!-- Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#announcementCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="isually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#announcementCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Laboratory Rules Card -->
  <div class="col-sm-6 mb-3 mb-sm-0">
    <div class="card h-100">
      <div class="card-header text-center fs-3" style="background-color: #3c6e7a; color: white;">
        Laboratory Rules
      </div>
      <ul class="list-group list-group-flush flex-grow-1">
        <li class="list-group-item text-left">No eating and drinking inside the laboratory.</li>
        <li class="list-group-item text-left">No student shall enter the laboratory without the permission of the faculty.</li>
        <li class="list-group-item text-left">Always make sure that lights and power inside the laboratory is turned off.</li>
        <li class="list-group-item text-left">Make sure to shutdown the computer before leaving the laboratory</li>
      </ul>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col d-flex justify-content-end" style="margin-top:20px;">
    <a href="st-view-event.php" class="btn btn-warning">View Events</a>
  </div>
</div>


<div class="row mb-3"> <!-- Reduced margin-bottom -->
  <div class="col">
    <table class="table">
      <thead class="table-info">
                    <tr>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Time</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Course Code</th>
<th scope="col" style="background-color: #3c6e7a; color: white;">Course Description</th>

                      <th scope="col" style="background-color: #3c6e7a; color: white;">Faculty Name</th>
                      <th scope="col" style="background-color: #3c6e7a; color: white;">Status</th>
                    </tr>
                  </thead>
                  <tbody>
 <?php if ($result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><b><?php echo htmlspecialchars(date("h:i A", strtotime($row['start_time'])) . " - " . date("h:i A", strtotime($row['end_time']))); ?></b></td>
      <td><?php echo htmlspecialchars($row['course_code']); ?></td>
      <td><?php echo htmlspecialchars($row['course_desc']); ?></td>
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
  <tr><td colspan="5">No schedules found for today.</td></tr>
<?php endif; ?>

</td>

                        </tr>
                   
                  </tbody>
                </table>


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

  </body>
</html>