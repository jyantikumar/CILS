<?php
include 'connection.php';

if (isset($_POST['create-sched'])) {
    $purpose = "CLASS";
    $sem = strtoupper($_POST['sem']);
    $program = strtoupper($_POST['program']);
    $level = strtoupper($_POST['level']);
    $section = strtoupper($_POST['section']);
    $course_code = strtoupper($_POST['course_code']);
    $course_desc = strtoupper($_POST['course_desc']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $start_time = strtoupper($_POST['start_time']);
    $end_time = strtoupper($_POST['end_time']);
    $faculty = strtoupper($_POST['faculty']);
    $days = isset($_POST['days']) ? $_POST['days'] : [];
    $status = "UPCOMING";

    // Input validation
    if (strtotime($end_date) < strtotime($start_date)) {
        echo "<script>alert('End date cannot be before start date'); window.history.back();</script>";
        exit();
    }

    if (strtotime($end_time) <= strtotime($start_time)) {
        echo "<script>alert('End time must be after start time'); window.history.back();</script>";
        exit();
    }

    // Prepare time comparisons
    $start_time_compare = date('H:i:s', strtotime($start_time));
    $end_time_compare = date('H:i:s', strtotime($end_time));
    
    // Initialize variables
    $current_date = new DateTime($start_date, new DateTimeZone('Asia/Manila'));
    $end_date_obj = new DateTime($end_date, new DateTimeZone('Asia/Manila'));
    $has_conflict = false;
    
    // Convert days to day numbers (1-7)
    $day_nums = array_map(function($day) {
        return date('N', strtotime($day));
    }, $days);
    $days_string = !empty($days) ? implode(",", $days) : NULL;

    if ($start_date == $end_date) {
        // One-time schedule handling
        $schedule_date = $start_date;
        $recurrence_type = "ONETIME";
    
        
        // Check for conflicts
        $check_sql = "SELECT * FROM create_sched 
        WHERE (
            (start_date = '$schedule_date' AND end_date = '$schedule_date') OR
            ('$schedule_date' BETWEEN start_date AND end_date)
        )
        AND '$start_time_compare' < end_time
        AND '$end_time_compare' > start_time
        AND (recurrence_type = 'ONETIME' OR 
            (recurrence_type = 'WEEKLY' AND FIND_IN_SET(DAYNAME('$schedule_date'), repeat_sched)))";
        
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $has_conflict = true;
        } else {
            // Insert one-time schedule
            $sql = "INSERT INTO create_sched (
              purpose, sem, program, level, section, course_code, course_desc,
              start_time, end_time, start_date, end_date,
              repeat_sched, recurrence_type, faculty, status
          ) VALUES (
              '$purpose', '$sem', '$program', '$level', '$section',
              '$course_code', '$course_desc', '$start_time', '$end_time',
              '$schedule_date', '$schedule_date', '',
              '$recurrence_type', '$faculty', '$status'
          )";
            
            if (!$conn->query($sql)) {
                echo "<script>alert('Error creating schedule:'); window.history.back();</script>";
                exit();
            }
        }
    } else {
        // Recurring schedule handling
        $recurrence_type = "WEEKLY";
        
        if (empty($days)) {
            echo "<script>alert('Please select at least one recurrence day'); window.history.back();</script>";
            exit();
        }

        // Loop through each day in date range
        while ($current_date <= $end_date_obj) {
            $day_of_week = $current_date->format('N');
            $schedule_date = $current_date->format('Y-m-d');

            if (in_array($day_of_week, $day_nums)) {
                // Check for conflicts
                $check_sql = "SELECT * FROM create_sched 
                WHERE start_date <= '$schedule_date' AND end_date >= '$schedule_date'
                AND '$start_time_compare' < end_time
                AND '$end_time_compare' > start_time
                AND FIND_IN_SET(DAYNAME('$schedule_date'), repeat_sched)
                AND faculty = '$faculty'";
                
                $check_result = mysqli_query($conn, $check_sql);
                
                if (mysqli_num_rows($check_result) > 0) {
                    $has_conflict = true;
                } else {
                    // Insert recurring schedule instance
                    $sql = "INSERT INTO create_sched (
                        purpose, sem, program, level, section, course_code, course_desc,
                        start_time, end_time, start_date, end_date,
                        repeat_sched, recurrence_type, faculty, status
                    ) VALUES (
                        '$purpose', '$sem', '$program', '$level', '$section',
                        '$course_code', '$course_desc', '$start_time', '$end_time',
                        '$schedule_date', '$schedule_date', '$days_string',
                        '$recurrence_type', '$faculty', '$status'
                    )";
                    
                    if (!$conn->query($sql)) {
                        echo "<script>alert('Error creating schedule for $schedule_date: " . addslashes($conn->error) . "'); window.history.back();</script>";
                        exit();
                    }
                }
            }
            $current_date->modify('+1 day');
        }
    }

    // Final response
    if ($has_conflict) {
        echo "<script>alert('Conflicting schedule exists. No schedules were added.'); window.history.back();</script>";
    } else {
        header("location:view.php");
    }
    exit();
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
                      <h3 class="card-title fw-semibold text-center mb-5">Create New Schedule</h3>
                      <form action="" method="POST">

                      <div class="row mx-5">
                        
                      <div class="col-6 pb-4">
                          <label for="semester" class="form-label">Semester</label>
                          <select class="form-select" id="semester" name="sem" required>
                          <option selected>Choose...</option>
                              <option value="First Semester">FIRST SEMESTER</option>
                              <option value="Second Semester">SECOND SEMESTER</option>
                              <option value="SUMMER CLASSES">SUMMER CLASSES</option>
                          </select>
                      </div>
                        <div class="col-6 pb-4">
                          <label for="time" class="form-label">Input Program</label>
                          <select class="form-select" id="program" aria-label="Default select example" name="program" required>
                                  <option selected>Choose...</option>
                                  <option value="COMPUTER SCIENCE">COMPUTER SCIENCE</option>
                                  <option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
                         </select>                      
                         </div>

                              <div class="col-6 pb-4">
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
                          <label for="time" class="form-label">Section</label>
                          <input type="text" class="form-control" id="class-name" placeholder="Enter Section" name="section" required>
                        </div>
                        <div class="col-6 pb-4">
                            <label for="course-desc" class="form-label">Course Description</label>
                            <select class="form-select" name="course_desc" id="course_desc" required>
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="col-6 pb-4"> <!-- Display na lang course code pagkaselect ng course desc!-->
                          <label for="class-name" class="form-label">Course Code</label>
                          <input type="text" class="form-control" id="class-name" name="course_code" readonly style="background-color:#e6e6e6;">
                        </div>

                        


                      <div class="col-6 pb-4">
                          <label for="start-date" class="form-label">Start Date</label>
                          <input type="date" class="form-control" id="start-date" name="start_date" required>
                      </div>
                      <div class="col-6 pb-4">
                          <label for="end-date" class="form-label">End Date </label>
                          <input type="date" class="form-control" id="end-date" name="end_date" required>
                      </div>
                      <div class="col-6 pb-4">
                          <label for="start-date" class="form-label">Start Time</label>
                          <input type="time" class="form-control" id="start-time" name="start_time" required>
                      </div>
                      <div class="col-6 pb-4">
                          <label for="end-date" class="form-label">End Time</label>
                          <input type="time" class="form-control" id="end-time" name="end_time" required>
                      </div>
                      <div class="col-6 pb-4">
                          <label for="faculty" class="form-label">Select Faculty</label>
                          <select class="form-select" name="faculty">
                              <option selected>Choose...</option>
                              <?php
                              //include 'connection.php'; // Ensure connection is included

                              $query = "SELECT faculty_id, faculty_name FROM faculty_tbl where faculty_status='ACTIVE'";
                              $result = mysqli_query($conn, $query);

                              while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['faculty_name'] . "'>" . $row['faculty_name'] . "</option>";
                              }
                              ?>
                          </select>
                      </div>
                      <div class="col-6 pb-4 repeats-on-section">
    <label class="form-label">Repeats on</label>
    <div class="d-flex flex-wrap gap-2">
        <label><input type="checkbox" name="days[]" value="Sunday"> Sunday</label>
        <label><input type="checkbox" name="days[]" value="Monday"> Monday</label>
        <label><input type="checkbox" name="days[]" value="Tuesday"> Tuesday</label>
        <label><input type="checkbox" name="days[]" value="Wednesday"> Wednesday</label>
        <label><input type="checkbox" name="days[]" value="Thursday"> Thursday</label>
        <label><input type="checkbox" name="days[]" value="Friday"> Friday</label>
        <label><input type="checkbox" name="days[]" value="Saturday"> Saturday</label>
    </div>
</div>

                      
                            
                      </div>
                      <button type="submit" class="btn float-end" style="background-color: #3c6e7a; color: white;" name="create-sched">Create Schedule</button>

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

    function toggleRepeatsOn() {
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();
        
        if (startDate && endDate && startDate === endDate) {
            $('.repeats-on-section').hide();
        } else {
            $('.repeats-on-section').show();
        }
    }

    $('#start-date, #end-date').on('change', toggleRepeatsOn);
    toggleRepeatsOn();
});

$(document).ready(function () {
    function fetchCourses() {
        const program = $('#program').val();
        const semester = $('#semester').val();
        const level = $('#year_level').val();

        if (program !== 'Choose...' && semester !== 'Choose...' && level !== 'Choose...') {
            $.ajax({
                url: 'courses.php',
                type: 'POST',
                data: {
                    program: program,
                    semester: semester,
                    level: level
                },
                success: function (response) {
                    const courses = JSON.parse(response);
                    const courseSelect = $('#course_desc');
                    courseSelect.empty().append('<option selected>Choose...</option>');
                    courses.forEach(course => {
                        courseSelect.append(
                            `<option value="${course.course_desc}" data-code="${course.course_code}">
                                ${course.course_desc}
                            </option>`
                        );
                    });
                }
            });
        }
    }

    $('#program, #semester, #year_level').change(fetchCourses);

    $('#course_desc').change(function () {
        const selectedOption = $(this).find(':selected');
        const courseCode = selectedOption.data('code');
        $('input[name="course_code"]').val(courseCode || '');
    });
});
</script>





</body>
</html>