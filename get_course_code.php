<?php
include 'connection.php';

if (isset($_POST['program'], $_POST['sem'], $_POST['level'], $_POST['course_desc'])) {
    $program = strtoupper($_POST['program']);
    $semester = strtoupper($_POST['sem']);
    $level = strtoupper($_POST['level']);
    $course_desc = strtoupper($_POST['course_desc']);

    $query = "SELECT course_code FROM courses 
              WHERE program = '$program' 
              AND semester = '$semester' 
              AND level = '$level' 
              AND course_desc = '$course_desc'";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['course_code']; // Return the course code
    } else {
        echo ''; // Return empty if not found
    }
}
?>
