<?php
// Include database connection
include_once('dbconnect.php');

// Initialize message variable
$msg = '';
$firstname = "";
$lastname = "";
$email = "";
$password = "";
$username = "";
$phoneNumber="";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // Validate form data
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phoneNumber) || empty($password) || empty($username)) {
        $msg = "Please fill out all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format";
    } elseif (!preg_match("/^[0-9]{8}$/", $phoneNumber)) {
        $msg = "Invalid phone number";
    } elseif (strlen($password) < 6) {
        $msg = "Password must be at least 6 characters long";
    } else {
        try {
            // Insert user data into database
            $stmt = $conn->prepare("INSERT INTO JobSeeker (firstname, lastname, email, phoneNumber, password, username) 
                                    VALUES (:firstname, :lastname, :email, :phoneNumber, :password, :username)");
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $msg = "Registration successful!";
            header('Location: login.php');
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
  <title>Signup</title>

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
    <h1>Register as Job Seeker</h1>
    
        <?php if (!empty($msg)): ?>
            <div class="alert <?php echo ($msg == 'Registration successful!') ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="signup.php">
        <div class="form-group">
          <label for="firstname">First Name</label>
          <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>">
        </div>
        <div class="form-group">
          <label for="lastname">Last Name</label>
          <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
          <label for="phoneNumber">Phone Number</label>
          <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
        </div>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>">
        </div>
        <button type="submit" class="btn btn-dark mb-3" style="width:100%">Register</button>
      </form>

    
  
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
