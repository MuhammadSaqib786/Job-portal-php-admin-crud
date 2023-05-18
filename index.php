<?php
session_start();
if(!isset($_SESSION['user_email']))
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
  <h1>Welcome <?php echo $_SESSION['name']; ?></h1>
  <div>
    <p>Do you want to book a session? Below are some available sessions:</p>

    <?php
    // Include database connection
    include_once('dbconnect.php');

    try {
      // Fetch sessions from the Session table
      $stmt = $conn->prepare("SELECT session_name, session_time FROM Session");
      $stmt->execute();
      $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($sessions) > 0) {
    ?>
        <table class="table">
          <thead>
            <tr>
              <th>Session Name</th>
              <th>Session Time</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sessions as $session) { ?>
              <tr>
                <td><?php echo $session['session_name']; ?></td>
                <td><?php echo $session['session_time']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php
      } else {
        echo 'No sessions available.';
      }
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
      ?>
  </div>
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
