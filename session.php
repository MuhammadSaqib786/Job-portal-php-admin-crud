<?php

session_start();
if(!isset($_SESSION['user_email']))
{
    header('Location: login.php');
    exit;
}

// Include database connection
include_once('dbconnect.php');

// Initialize message variable
$msg = '';
$userId = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $appDate = $_POST['appDate'];
    $appTime = $_POST['appTime'];
    $appDescription = $_POST['appDescription'];
    $sessionId = $_POST['sessionId'];

    // Validate form data
    if (empty($appDate) || empty($appTime) || empty($appDescription) || empty($sessionId)) {
        $msg = "Please fill out all fields";
    } else {
        try {
            // Insert appointment data into database
            $stmt = $conn->prepare("INSERT INTO Appointment (appDate, appTime, appDescription, sessionId,jobseekerId) 
                                    VALUES (:appDate, :appTime, :appDescription, :sessionId, :jid)");
            $stmt->bindParam(':appDate', $appDate);
            $stmt->bindParam(':appTime', $appTime);
            $stmt->bindParam(':appDescription', $appDescription);
            $stmt->bindParam(':sessionId', $sessionId);
            $stmt->bindParam(':jid', $userId);
            $stmt->execute();

            $msg = "Appointment booked successfully!";
        } catch(PDOException $e) {
            $msg = "Connection failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Appointment</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
  include 'navbar.php';
?>
<div class="content">
  <h1>Welcome <?php echo $_SESSION['name']; ?></h1>
  <div>
    <h2>Book an Appointment</h2>
    <?php if (!empty($msg)): ?>
        <div class="alert <?php echo ($msg == 'Appointment booked successfully!') ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>
    <form method="post" action="session.php">
      <div class="form-group">
        <label for="appDate">Date</label>
        <input type="date" class="form-control" id="appDate" name="appDate">
      </div>
      <div class="form-group">
        <label for="appTime">Time</label>
        <input type="time" class="form-control" id="appTime" name="appTime">
      </div>
      <div class="form-group">
        <label for="appDescription">Description</label>
        <textarea class="form-control" id="appDescription" name="appDescription" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label for="sessionId">Session</label>
        <select class="form-control" id="sessionId" name="sessionId">
          <?php
          // Fetch sessions from the Session table
          try {
              $stmt = $conn->prepare("SELECT SessionId, session_name FROM Session");
              $stmt->execute();
              $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($sessions as $session) {
                  echo '<option value="' . $session['SessionId'] . '">' . $session['session_name'] . '</option>';
              }
          } catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
          }
          ?>
        </select>
      </div>
      <button type="submit" class="btn btn-dark mb-3" style="width:100%">Book Appointment</button>
    </form>
  </div>
</div>
