<?php require 'connection.php';
	if (isset($_GET['completed'])) {
    $id = $_GET['completed'];
      $update_sql= mysqli_query($connection,"UPDATE book SET approvel='Complete' WHERE id='$id'");
      header('location: ../riderdashboard?message_success= Ride Completed.',true,  302);
    }  
?>