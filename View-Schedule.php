<?php
include 'connection.php';

$query = "SELECT * FROM create_event ORDER BY eStart_date, eStart_time";
$result = mysqli_query($conn, $query);


?>

<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab Scheduler - View Schedule</title>
  <link rel="icon" type="image/x-icon" href="/assets/Scitech logo.png" />

  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
  <div class="container" style="max-width: 1920px;">
    <h1 class="text-center my-5">View Schedule</h1>
    <div class="row mb-5">
      <div class="col">
        <table class="table">
          <thead class="table-info">
              <th scope="col">Time</th>
              <th scope="col">Date</th>
              <th scope="col">Event name</th>
            </tr>
          </thead>
          <tbody>
            <?php
          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $time = date("h:i A", strtotime($row['eStart_time'])) . " - " . date("h:i A", strtotime($row['eEnd_time']));
                $date = date("F d, Y", strtotime($row['eStart_date']));
                $event = htmlspecialchars($row['event_name']);
              }}
              else {
                echo "<tr><td colspan='3' class='text-center'>No events found.</td></tr>";
              }
                ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
