<?php
include 'connection.php';

$program = $_POST['program'];
$semester = $_POST['semester'];
$level = $_POST['level'];

$table = '';
if ($program === 'COMPUTER SCIENCE') {
    $table = 'COMPUTER SCIENCE';
} elseif ($program === 'INFORMATION TECHNOLOGY') {
    $table = 'INFORMATION TECHNOLOGY';
} else {
    echo json_encode([]);
    exit;
}

$sql = "SELECT course_code, course_desc FROM it 
        WHERE semester = '$semester' AND level = '$level' and program='$program'";
$result = mysqli_query($conn, $sql);

$courses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}

echo json_encode($courses);
?>
