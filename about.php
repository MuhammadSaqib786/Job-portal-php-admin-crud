<?php
session_start();

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
<div class="container">
    <h1 class="mt-5">About Us</h1>
    <p class="lead">Our project aims to assist graduates and job seekers in developing and enhancing their skills. Through our website, individuals can register themselves and gain access to various training sessions and resources. By using their valid username and password, job seekers can log in to the application and explore the available sessions and training opportunities.</p>
    <p class="lead">Additionally, staff members and volunteers can also register themselves using their unique credentials to access the application. As an administrator, the management console provides access to the application's administrative functions, such as adding, deleting, updating, and finding sessions and training programs.</p>
    <p class="lead">Our platform offers job seekers the flexibility to choose from a range of available sessions and training programs. In case of any scheduling conflicts, job seekers can easily cancel their training sessions by providing early notice. Furthermore, we provide a secure payment system for job seekers to conveniently pay for their chosen trainings.</p>
    <p class="lead">Our platform is designed to provide seamless access to courses, allowing students to learn at their own pace and from any location. Whether it's acquiring new skills or enhancing existing ones, our platform offers a user-friendly and accessible learning environment for job seekers and students.</p>
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
