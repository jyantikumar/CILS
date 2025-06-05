<?php
include 'connection.php';
//session_start();

$ann_sql='SELECT * FROM announcement_tbl order by ann_start desc';
$ann_result=$conn->query($ann_sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CS/IT Laboratory Scheduler</title>
    <style>
        /* Add this to your CSS file */
.wider-content {
    width: 100%; /* or any custom width you prefer */
}
table {
  table-layout: fixed;  /* Ensures cells do not stretch based on content */
  width: 100%;
}

td {
  padding: 10px;  /* Adjust padding if needed */
}

th, td {
  text-align: left;
}
  .action-container {
    position: relative;
    display: inline-block;
  }

  .ellipsis-btn {
    cursor: pointer;
    font-size: 24px;
    border: none;
    background: transparent;
    color: #3c6e7a;
  }
    .ellipsis-btn:hover {
    cursor: pointer;
    font-size: 24px;
    border: none;
    background: #3c6e7a;
    color: #ffffff;
border-radius:5px;
  }


.action-buttons {
  display: none;
  position: absolute;
  bottom: 100%;       /* place above the button */
  left: 50%;          /* center horizontally relative to button */
transform: translateX(-50%) translateY(4px);
  white-space: nowrap;
  background: white;
  border-radius: 4px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  padding: 0.25rem 0.5rem;
  z-index: 1000;
}
.action-container:hover .action-buttons {
  display: flex;
  gap: 0.5rem;
}
    </style>
    <link rel="icon" type="image/x-icon" href="http://localhost/CILS/assets/Scitech logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="announcement.css">
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
              <li class="sidebar-item active">
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
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
              <i class="lni lni-user"></i>
              <span>Multi Level</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled collapse" id="multi" data-bs-parent="#sidebar">
              <li class="sidebar-item">
                <a href="#" class="sidebar-link  collapsed" data-bs-toggle="collapse" data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                  Two Links
                </a>
                <ul class="sidebar-dropdown list-unstyled collapse" id="multi-two">
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Link 1</a>
                  </li>
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Link 2</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li> -->
          <!--<li class="sidebar-item">
            <a href="conflict.php" class="sidebar-link">
              <i class="lni lni-popup"></i>
              <span>Conflict Alerts</span>
            </a>
          </li> !-->
          <!-- <li class="sidebar-item">
            <a href="#" class="sidebar-link">
              <i class="lni lni-cog"></i>
              <span>Settings</span>
            </a>
          </li> -->
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
          </div>
        </nav>
        <main class="content px-3 py-4">

          <section id="dashboard" class="mx-4 pb-0" style="font-family: 'Montserrat';">

            <div class="container" style="max-width: 1920px;">
              <h1 class="text-center my-5">View Announcements</h1>
              <div class="input-group" style="max-width: 400px;">

            <form action="search_class.php" method="GET" style="max-width: 400px; margin-bottom: 30px;">
              <div class="input-group">
                <input type="date" class="form-control" name="search_date" placeholder="Search by date (YYYY-MM-DD)">
                <button class="btn btn-info" type="submit" id="search-btn">
                  <i class="lni lni-search-alt"></i> Search
                </button>
              </div>
            </form>

              <br>
              
            </div>
              <div class="row mb-5">
                <div class="col">
                  <table class="table">
                    <thead class="table-info">
                      <tr>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Date</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Title</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Content</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Status</th>
                        <th scope="col" style="background-color: #3c6e7a; color: white;">Actions</th>

                      </tr>
                    </thead>
            <tbody>
                <?php while ($row = $ann_result->fetch_assoc()) { 
                    $status = (strtotime($row['ann_end']) < time()) ? 'Expired' : 'Active';
                    $short_content = strlen($row['ann_content']) > 10 ? substr($row['ann_content'], 0, 10) . '...' : $row['ann_content'];
                ?>
                <tr>
                <td><?php echo date('F j, Y', strtotime($row['ann_start'])) . ' - ' . date('F j, Y', strtotime($row['ann_end'])); ?></td>
                <td><?php echo $row['ann_title']; ?></td>
                <td><?php echo $short_content; ?></td>
                <TD>
                          <?php 
                                      $schedDate = $row['ann_start'];
                                      $schedEnd = $row['ann_end'];
                                      
                                      // Create DateTime objects for this specific schedule
                                      $schedStartDateTime = new DateTime("$schedDate");
                                      $schedEndDateTime = new DateTime("$schedEnd");
                                      
                                      // Format for JavaScript (ISO 8601 format)
                                      $startISO = $schedStartDateTime->format('c');
                                      $endISO = $schedEndDateTime->format('c');
                                      ?>
                                      <span class="badge status-badge" 
                                            data-start="<?php echo $startISO; ?>" 
                                            data-end="<?php echo $endISO; ?>">
                                          <?php 
                                          if ($currentDateTime >= $schedStartDateTime && $currentDateTime <= $schedEndDateTime) {
                                              echo 'ONGOING';
                                          } elseif ($currentDateTime > $schedEndDateTime) {
                                              echo 'DONE';
                                          } elseif ($currentDateTime < $schedStartDateTime) {
                                              echo 'UPCOMING';
                                          } else {
                                              echo 'CANCELLED';
                                          }
                                          ?>
                                      </span>
                                  </td>
                <td>
                                                 <div class="action-container">
  <button class="ellipsis-btn" aria-label="Actions">&#8942;</button>
  <div class="action-buttons">
   <button class="btn btn-info" onclick="toggleContent(<?php echo $row['ann_id']; ?>)">Show More</button>
                  <a href="edit_ann.php?ann_id=<?php echo $row['ann_id']; ?>" class="btn btn-warning">Edit</a>
  </div>
</div>

                  </td>
              </tr>

                <!-- Full Content (Initially Hidden) -->
                <tr id="content-<?php echo $row['ann_id']; ?>" style="display:none;">
  <td colspan="5">
    <div class="card w-100">
      <div class="card-body">
        <p><?php echo $row['ann_content']; ?></p>
      </div>
    </div>
  </td>
</tr>


                <?php } ?>
            </tbody>
        </table>
        <!-- End of Table -->
        
    </div>
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

    function toggleContent(id) {
    const contentRow = document.getElementById('content-' + id);
    const td = contentRow.querySelector('td');
    if (contentRow.style.display === 'none') {
        contentRow.style.display = 'table-row';
        td.classList.add('wider-content');  // Apply wider content style
    } else {
        contentRow.style.display = 'none';
        td.classList.remove('wider-content');  // Remove wider content style
    }
}
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

const statusUpdateInterval = setInterval(updateStatusBadges, 1000);

document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        // Immediate update when tab becomes visible
        updateStatusBadges();
        // Reset the regular interval
        clearInterval(statusUpdateInterval);
        setInterval(updateStatusBadges, 1000);
    }
});

window.addEventListener('beforeunload', function() {
    clearInterval(statusUpdateInterval);
});
    </script>

    </script>
  </body>
</html>
