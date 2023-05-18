<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
include_once('dbconnect.php');

// Initialize variables
$sessionName = '';
$sessionTime = '';
$msg = '';

// Check if session ID is provided in the URL
if (isset($_GET['id'])) {
    $sessionId = $_GET['id'];

    // Fetch session data from the database
    try {
        $stmt = $conn->prepare("SELECT * FROM Session WHERE SessionId = :sessionId");
        $stmt->bindParam(':sessionId', $sessionId);
        $stmt->execute();
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set the form values
        $sessionName = $session['session_name'];
        $sessionTime = $session['session_time'];
    } catch (PDOException $e) {
        $msg = 'Connection failed: ' . $e->getMessage();
    }
}

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
            // Update session data in the database
            $stmt = $conn->prepare("UPDATE Session SET session_name = :sessionName, session_time = :sessionTime WHERE SessionId = :sessionId");
            $stmt->bindParam(':sessionName', $sessionName);
            $stmt->bindParam(':sessionTime', $sessionTime);
            $stmt->bindParam(':sessionId', $sessionId);
            $stmt->execute();

            $msg = 'Session updated successfully!';
            header('Location: adminhome.php');
            exit;
        } catch (PDOException $e) {
            $msg = 'Connection failed: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Session</title>

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
  <h1>Edit Session</h1>

  <?php if (!empty($msg)): ?>
    <div class="alert <?php echo ($msg == 'Session updated successfully!') ? 'alert-success' : 'alert-danger'; ?>">
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
    <button type="submit" class="btn btn-primary">Update Session</button>
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
