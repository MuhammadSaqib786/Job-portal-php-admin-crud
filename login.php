<?php
// Include database connection
include_once('dbconnect.php');

// Initialize message variable
$msg = '';
$email = '';
$password = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate form data
    if (empty($email) || empty($password)) {
        $msg = "Please enter email and password";
    } else {
        try {
            // Query to check if user with email and password exists
            $stmt = $conn->prepare("SELECT * FROM JobSeeker WHERE email=:email AND password=:password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if user exists
            if ($user) {
                // Start session and set user id as session variable
                session_start();
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['name'] = $user['firstname']." ".$user['lastname'];
                $_SESSION['user_id'] = $user['jobseekerId'];

                // Redirect to product page
                header('Location: index.php');
                exit;
            } else {
                $msg = "Invalid email or password";
            }
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
  <title>Login</title>

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
    <h1>Job Seeker Login</h1>
    
        <?php if (!empty($msg)): ?>
            <div class="alert alert-danger">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
    <form action="login.php" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-dark mb-3" style="width:100%">Login</button>
    </form>
    
    
  
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
