<?php
session_start();
if(!isset($_SESSION['admin_name']))
{
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>

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
  <h1>Welcome <?php echo $_SESSION['admin_name']; ?></h1>

  <?php
  // Include database connection
  include_once('dbconnect.php');

  try {
    // Fetch appointments with session details from the Appointment table
    $stmt = $conn->prepare("SELECT a.appId, a.appDate, a.appTime, a.AppDescription, s.session_name
                            FROM Appointment a
                            INNER JOIN Session s ON a.sessionId = s.SessionId");
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($appointments) > 0) {
      echo '<table class="table">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Appointment ID</th>';
      echo '<th>Date</th>';
      echo '<th>Time</th>';
      echo '<th>Description</th>';
      echo '<th>Session</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      foreach ($appointments as $appointment) {
        echo '<tr>';
        echo '<td>' . $appointment['appId'] . '</td>';
        echo '<td>' . $appointment['appDate'] . '</td>';
        echo '<td>' . $appointment['appTime'] . '</td>';
        echo '<td>' . $appointment['AppDescription'] . '</td>';
        echo '<td>' . $appointment['session_name'] . '</td>';
        
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';
    } else {
      echo 'No appointments found. (Right now no job seeker has requested for appointment.)';
    }
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  ?>


<div class="mt-5">
  <h2>Available Sessions</h2>
  <?php
  try {
    // Fetch available sessions from the Session table
    $stmt = $conn->prepare("SELECT * FROM Session");
    $stmt->execute();
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($sessions) > 0) {
      echo '<table class="table">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Session ID</th>';
      echo '<th>Session Name</th>';
      echo '<th>Session Time</th>';
      echo '<th>Actions</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      foreach ($sessions as $session) {
        echo '<tr>';
        echo '<td>' . $session['SessionId'] . '</td>';
        echo '<td>' . $session['session_name'] . '</td>';
        echo '<td>' . $session['session_time'] . '</td>';
        echo '<td>';
        echo '<a href="edit.php?id=' . $session['SessionId'] . '" class="btn btn-primary btn-sm">Edit</a>';
        echo '&nbsp;';
        echo '<a href="delete.php?id=' . $session['SessionId'] . '" class="btn btn-danger btn-sm">Delete</a>';
        echo '</td>';
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';
    } else {
      echo 'No sessions found.';
    }
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  ?>
</div>


</div>
<div class="container">
    <h1>Add Session</h1>

    <?php
    // Include database connection
    include_once('dbconnect.php');

    // Initialize variables
    $sessionName = '';
    $sessionTime = '';
    $msg = '';

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Retrieve form data
      $sessionName = $_POST['sessionName'];
      $sessionTime = $_POST['sessionTime'];

      // Validate form data
      if (empty($sessionName) || empty($sessionTime)) {
        $msg = 'Please fill out all fields';
      } else {
        try {
          // Insert session data into database
          $stmt = $conn->prepare("INSERT INTO Session (session_name, session_time) VALUES (:sessionName, :sessionTime)");
          $stmt->bindParam(':sessionName', $sessionName);
          $stmt->bindParam(':sessionTime', $sessionTime);
          $stmt->execute();

          $msg = 'Session added successfully!';
        } catch(PDOException $e) {
          $msg = 'Connection failed: ' . $e->getMessage();
        }
      }
    }
    ?>

    <?php if (!empty($msg)): ?>
      <div class="alert <?php echo ($msg == 'Session added successfully!') ? 'alert-success' : 'alert-danger'; ?>">
        <?php echo $msg; ?>
      </div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="form-group">
        <label for="sessionName">Session Name</label>
        <input type="text" class="form-control" id="sessionName" name="sessionName" value="<?php echo $sessionName; ?>">
      </div>
      <div class="form-group">
        <label for="sessionTime">Session Time</label>
        <input type="datetime-local" class="form-control" id="sessionTime" name="sessionTime" value="<?php echo $sessionTime; ?>">
      </div>
      <button type="submit" class="btn btn-primary">Add Session</button>
    </form>
  </div>


  <footer class="text-white text-center p-3" style="bg-color: #28A745;">
    Copyright &copy; All Rights Reserved
  </footer>
  
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
