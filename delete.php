<?php
// Include database connection
include_once('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
  $appId = $_GET['id'];

  try {
    // Delete the appointment from the database
    $stmt = $conn->prepare("DELETE FROM Session WHERE SessionId = :appId");
    $stmt->bindParam(':appId', $appId);
    $stmt->execute();

    // Check if any rows were affected
    if ($stmt->rowCount() > 0) {
        header('Location: adminHome.php');
    } else {
      echo "No appointment found with the provided ID.";
    }
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
} else {
  echo "Invalid request!";
}
?>
