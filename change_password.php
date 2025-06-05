<?php
include 'connection.php';

$new_pass=$_POST['new_pass'];
$confirm_pass=$_POST['confirm_pass'];


$sql="Update "
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password?</title>
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
                <a href="newSched.php" class="sidebar-link">Add Class</a>
              </li>
              <li class="sidebar-item active">
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
                  <a href="" class="nav-icon pe-md-0" data-bs-toggle="dropdown">
                    
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
                      <h3 class="card-title fw-semibold text-center mb-5">Change Password</h3>
                     
                      <form action="" method="POST">
                      <div class="row mx-5">
                      <div class="col-12 pb-4">
                          <label for="semester" class="form-label">New Password</label>
                          <input type="password" class="form-control" id="class-name" name="new_pass">
                      </div>

                      <div class="col-12 pb-4">
                          <label for="start-date" class="form-label">Confirm Password</label>
                          <input type="password" class="form-control" id="class-name" name="confirm_pass">
                      </div>
                  
                    <!---
                          <div class="col-6 pb-4">
                          <label for="time" class="form-label">Status</label>
                          <select class="form-select" aria-label="Default select example" name="status">
                            <option value="ONGOING">Ongoing</option>
                            <option value="DONE">Done</option>
                            <option value="UPCOMING">Upcoming</option>
                            <option value="CANCELLED">Cancelled</option>
                          </select>
                        </div> !-->
                     
                      </div>
                      
                      <button type="submit" class="btn float-end" style="background-color: #3c6e7a; color: white;" name="create-sched">Change Password</button>
                      </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const checkboxes = document.querySelectorAll('input[name="days[]"]'); // Get all the checkboxes
    const repeatsOnSection = document.querySelector('.repeats-on-section'); // The section to hide

    // Function to check and hide labels if dates are the same
    function checkDates() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        if (startDate === endDate) {
            // Hide the "Repeats on" section and its checkboxes if the dates are the same
            repeatsOnSection.style.display = 'none'; // Hide the entire "Repeats on" section
        } else {
            // Show the "Repeats on" section again if the dates are different
            repeatsOnSection.style.display = 'block'; // Show the "Repeats on" section
        }

        // Hide the checkboxes within the section
        checkboxes.forEach(checkbox => {
            const label = checkbox.closest('label');
            if (label) {
                if (startDate === endDate) {
                    label.style.display = 'none'; // Hide label (and checkbox within it)
                } else {
                    label.style.display = 'inline-block'; // Show label (and checkbox within it)
                }
            }
        });
    }

    // Add event listeners for changes on either of the date inputs
    startDateInput.addEventListener('change', checkDates);
    endDateInput.addEventListener('change', checkDates);

    // Initial check in case the dates are pre-filled
    checkDates();
});
</script>

</script>





</body>
</html>