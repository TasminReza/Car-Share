<?php require 'connection.php';
	if (isset($_GET['active'])) {
    $vehicle_code = $_GET['active'];
      $update_sql= mysqli_query($connection,"UPDATE vehicle SET status='Active' WHERE vehicle_id='$vehicle_code'");
      header('location: ../vehicle_approval?message_success=Vehicle is in Service.',true,  302);
    }  
    if (isset($_GET['inactive'])) {
      $vehicle_code = $_GET['inactive'];
        $update_sql= mysqli_query($connection,"UPDATE vehicle SET status='Inactive' WHERE vehicle_id='$vehicle_code'");
        header('location: ../vehicle_approval?message_warning=Vehicle is terminated from service.',true,  302);
      }  
?>