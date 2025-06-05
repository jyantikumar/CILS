<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sched_id = intval($_POST['sched_id']); // Securely get sched_id

    if (isset($_POST['cancel'])) {
        // Cancel class by updating status
        $cancel = "UPDATE create_sched SET status='CANCELLED' WHERE sched_id = '$sched_id'";
        if (mysqli_query($conn, $cancel)) {
            echo "<script>alert('Class canceled.'); window.location='view.php';</script>";
        } else {
            echo "Error canceling class: " . mysqli_error($conn);
        }
        
    } elseif (isset($_POST['uncancel'])) {
        $sql = "UPDATE create_sched SET status='UPCOMING' WHERE sched_id = $sched_id";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }elseif (isset($_POST["save_changes"])) {
        // Process updates
        $purpose = "CLASS";
        $sem = strtoupper($_POST['sem']);
        $program = strtoupper($_POST['program']);  
        $level = strtoupper($_POST['level']);
        $section = strtoupper($_POST['section']);
        $course_code = strtoupper($_POST['course_code']);  
        $course_desc = strtoupper($_POST['course_desc']);
        $start_date = date("Y-m-d", strtotime($_POST['start_date']));
        $start_time = date("H:i:s", strtotime($_POST['start_time']));
        $end_time = date("H:i:s", strtotime($_POST['end_time']));
        
        if (strtotime($end_time) < strtotime($start_time)) {
            echo "<script>alert('End time cannot be before start time'); window.history.back();</script>";
            exit();
        }
        
        $faculty = strtoupper($_POST['faculty']);
        $status = "UPCOMING";
        $recurrence_type = "WEEKLY";

        // Update schedule
        $sql = "UPDATE create_sched SET
                purpose='$purpose', 
                sem='$sem',
                program='$program',
                level='$level', 
                section='$section', 
                course_code='$course_code',
                course_desc='$course_desc',
                start_time='$start_time',
                end_time='$end_time',
                recurrence_type='$recurrence_type',
                faculty='$faculty',
                status='$status'
                WHERE sched_id = '$sched_id'";

        if (mysqli_query($conn, $sql)) {
            header("Location: view_schedules.php");
            exit();
        } else {
            echo "Error updating schedule: " . mysqli_error($conn);
        }
    }
}

// Populate fields for editing
$row = null; // Initialize $row to avoid undefined variable error
if (isset($_GET["sched_id"])) {
    $sched_id = $_GET["sched_id"];
    $query = "SELECT * FROM create_sched WHERE sched_id = '$sched_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Schedule not found!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Schedule</title>
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
              <li class="sidebar-item active">
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
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#course" aria-expanded="false" aria-controls="course">
<i class="lni lni-book"></i>        <span>Curriculum</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled collapse" id="course" data-bs-parent="#sidebar">
              <li class="sidebar-item">
                <a href="add_courses.php" class="sidebar-link">Add Courses</a>
              </li>
              <li class="sidebar-item">
                <a href="view_courses.php" class="sidebar-link">View Curriculum</a>
              </li>
</ul>
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
                      <li class="sidebar-footer">
          <a href="logout.php" class="sidebar-link">
          <i class="lni lni-exit"></i>
              <span>Logout</span>
            </a>
          </li>
              <!--<li class="sidebar-item">
            <a href="conflict.php" class="sidebar-link">
              <i class="lni lni-popup"></i>
              <span>Conflict Alerts</span>
            </a>
          </li> !-->
         
      
        </ul>
        
      </aside>
        <div class="main">
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

            <main class="content px-3 py-4">
                <section class="mx-5">
                    <div class="row my-5">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title fw-semibold text-center mb-5">Edit Schedule</h3>
                                    <form action="" method="POST">
                                        <input type="hidden" name="sched_id" value="<?php echo isset($row['sched_id']) ? $row['sched_id'] : ''; ?>">
                                        <div class="row mx-5">
                                            <div class="col-6 pb-4">
                                                <label for="semester" class="form-label">Semester</label>
                                                <select class="form-select" id="sem" name="sem" required>
                                                    <option value="FIRST SEMESTER" <?php echo (isset($row['sem']) && $row['sem'] == 'FIRST SEMESTER') ? 'selected' : ''; ?>>First Semester</option>
                                                    <option value="SECOND SEMESTER" <?php echo (isset($row['sem']) && $row['sem'] == 'SECOND SEMESTER') ? 'selected' : ''; ?>>Second Semester</option>
                                                    <option value="SUMMER CLASSES" <?php echo (isset($row['sem']) && $row['sem'] == 'SUMMER CLASSES') ? 'selected' : ''; ?>>Summer Classes</option>
                                                </select>
                                            </div>
                                            <div class="col-6 pb-4">
                                                <label for="program" class="form-label">Select Program</label>
                                                <select class="form-select" id="program" name="program" required>
                                                    <option>Choose...</option>
                                                    <option value="COMPUTER SCIENCE" <?php echo (isset($row['program']) && $row['program'] == 'COMPUTER SCIENCE') ? 'selected' : ''; ?>>Computer Science</option>
                                                    <option value="INFORMATION TECHNOLOGY" <?php echo (isset($row['program']) && $row['program'] == 'INFORMATION TECHNOLOGY') ? 'selected' : ''; ?>>Information Technology</option>
                                                </select>
                                            </div>
                                            <div class="col-6 pb-4">
                                                <label for="level" class="form-label">Year Level</label>
                                                <select class="form-select" name="level" id="level" required>
                                                    <option>Choose...</option>
                                                    <option value="FIRST YEAR" <?php echo (isset($row['level']) && $row['level'] == 'FIRST YEAR') ? 'selected' : ''; ?>>First Year</option>
                                                    <option value="SECOND YEAR" <?php echo (isset($row['level']) && $row['level'] == 'SECOND YEAR') ? 'selected' : ''; ?>>Second Year</option>
                                                    <option value="THIRD YEAR" <?php echo (isset($row['level']) && $row['level'] == 'THIRD YEAR') ? 'selected' : ''; ?>>Third Year</option>
                                                    <option value="FOURTH YEAR" <?php echo (isset($row['level']) && $row['level'] == 'FOURTH YEAR') ? 'selected' : ''; ?>>Fourth Year</option>
                                                </select>
                                            </div>
                                            <div class="col-6 pb-4">
                                                <label for="section" class="form-label">Section</label>
                                                <input type="text" class="form-control" name="section" value="<?php echo isset($row['section']) ? $row['section'] : ''; ?>" required>
                                            </div>
                                            <div class="col-6 pb-4">
                                                <label for="course-desc" class="form-label">Course Description</label>
                                                <select class="form-select" name="course_desc" id="course_desc" required>
                                                    <option value="">Choose...</option>
                                                    <?php
                                                    // Use the values from the schedule being edited
                                                    $program = isset($row['program']) ? $row['program'] : '';
                                                    $level = isset($row['level']) ? $row['level'] : '';
                                                    $semester = isset($row['sem']) ? $row['sem'] : '';

                                                    // Prepare the query based on the program
                                                    if ($program == "INFORMATION TECHNOLOGY") {
                                                        $query = "SELECT course_desc, course_code FROM it WHERE level='$level' AND semester='$semester'";
                                                    } else {
                                                        $query = "SELECT course_desc, course_code FROM cs WHERE level='$level' AND semester='$semester'";
                                                    }

                                                    // Execute the query
                                                    $result = mysqli_query($conn, $query);
                                                    while ($row_course = mysqli_fetch_assoc($result)) {
                                                        $selected = (isset($row['course_desc']) && $row['course_desc'] == $row_course['course_desc']) ? 'selected' : '';
                                                        echo '<option value="' . htmlspecialchars($row_course['course_desc']) . '" ' . $selected . ' data-code="' . htmlspecialchars($row_course['course_code']) . '">' . htmlspecialchars($row_course['course_desc']) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6 pb-4">
                                                <label for="course_code" class="form-label">Course Code</label>
                                                <input type="text" class="form-control" id="course_code" name="course_code" readonly style="background-color:#e6e6e6;" value="<?php echo isset($row['course_code']) ? htmlspecialchars($row['course_code']) : ''; ?>">
                                            </div>
                                            <div class="col-6 pb-4">
                                                <label for="start_time" class="form-label">Start Time</label>
                                                <input type="time" class="form-control" name="start_time" value="<?php echo isset($row['start_time']) ? date("H:i", strtotime($row['start_time'])) : ''; ?>" required>
                                            </div>
                                            <div class="col-6 pb-4">
                                                <label for="end_time" class="form-label">End Time</label>
                                                <input type="time" class="form-control" name="end_time" value="<?php echo isset($row['end_time']) ? date("H:i", strtotime($row['end_time'])) : ''; ?>" required>
                                            </div>
                                            <div class="col-12 pb-4">
                                                <label for="faculty" class="form-label">Select Faculty</label>
                                                <select class="form-select" name="faculty" required>
                                                    <option selected><?php echo isset($row['faculty']) ? htmlspecialchars($row['faculty']) : ''; ?></option>
                                                    <?php
                                                    $query = "SELECT faculty_id, faculty_name FROM faculty_tbl";
                                                    $result = mysqli_query($conn, $query);
                                                    while ($facultyRow = mysqli_fetch_assoc($result)) {
                                                        if ($facultyRow['faculty_name'] != (isset($row['faculty']) ? $row['faculty'] : '')) {
                                                            echo "<option value='" . htmlspecialchars($facultyRow['faculty_name']) . "'>" . htmlspecialchars($facultyRow['faculty_name']) . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <input type="hidden" name="sched_id" value="<?php echo isset($row['sched_id']) ? $row['sched_id'] : ''; ?>">
                                            <div class="col-6 pb-4">
                                                <button type="submit" name="save_changes" class="btn float-end" style="background-color: #3c6e7a; color: white;">Save Changes</button>
                                            </div>
                                            <div class="col-6 pb-4">
 <?php if ($row['status'] == 'CANCELLED'): ?>
    <button type="submit" name="uncancel" class="btn btn-success">Uncancel Class</button>
  <?php else: ?>
    <button type="submit" name="cancel" class="btn btn-danger">Cancel Class</button>
  <?php endif; ?>                                            </div>
                                        </div>
                                    </form>
                                </div>
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
    // Function to fetch courses based on selected criteria
    function fetchCourses() {
        const program = $('#program').val();
        const semester = $('#sem').val(); // Changed from #semester to #sem
        const level = $('#level').val();   // Changed from #year_level to #level

        if (program && program !== 'Choose...' && semester && level && level !== 'Choose...') {
            $.ajax({
                url: 'courses.php',
                type: 'POST',
                data: {
                    program: program,
                    semester: semester,
                    level: level
                },
                success: function (response) {
                    try {
                        const courses = JSON.parse(response);
                        const courseSelect = $('#course_desc');
                        courseSelect.empty().append('<option selected>Choose...</option>');
                        
                        // Store the current selected value to maintain it after refresh
                        const currentSelected = '<?php echo $row["course_desc"]; ?>';
                        let found = false;
                        
                        courses.forEach(course => {
                            const option = new Option(course.course_desc, course.course_desc);
                            $(option).data('code', course.course_code);
                            if (course.course_desc === currentSelected) {
                                option.selected = true;
                                found = true;
                                // Update the course code field
                                $('#course_code').val(course.course_code);
                            }
                            courseSelect.append(option);
                        });
                        
                        if (!found && currentSelected) {
                            // If the original value isn't in the new list, add it back
                            courseSelect.prepend(new Option(currentSelected, currentSelected, true, true));
                        }
                    } catch (e) {
                        console.error("Error parsing courses response:", e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        }
    }

    // Set up event handlers
    $('#program, #sem, #level').change(fetchCourses);

    // Handle course description selection to update course code
    $('#course_desc').change(function () {
        const selectedOption = $(this).find(':selected');
        const courseCode = selectedOption.data('code');
        $('#course_code').val(courseCode || '');
    });

    // Initialize the form by fetching courses if values are already set
    if ($('#program').val() && $('#sem').val() && $('#level').val()) {
        fetchCourses();
    }
});
</script>
</body>
</html>
