
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="images/logo.png" class="img-responsive" style="width: 200px; height: 80px;" >
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="about.php">About us</a>
          </li>
          
          
          
          
          
      <?php
      if (isset($_SESSION['user_email'])) {
        // Show logout button with icon
        echo '
                <li class="nav-item">
                    <a class="nav-link" href="session.php">Book Session</a>
                </li>
                
                <li class="nav-item active">
                  <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
              ';
      } else if (isset($_SESSION['admin'])) 
      
      {
        echo '
        <li class="nav-item active">
                  <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>';

      }
      else {
        // Show signup and login links
        echo '
            <li class="nav-item">
            <a class="nav-link" href="admin.php">Admin Access</a>
          </li>
                    <li class="nav-item">
                  <a class="nav-link" href="signup.php">Sign Up</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="login.php">Login</a>
                </li>
              ';
      }
      ?>
      </ul>
    </div>
  </div>
</nav>