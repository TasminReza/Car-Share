<?php require 'connection.php';
	if (isset($_GET['active'])) {
    $code = $_GET['active'];
      $update_sql= mysqli_query($connection,"UPDATE rider SET status='Active' WHERE code='$code'");
      header('location: ../rider_list?message_success=User is Active in Access.',true,  302);
    }  
    if (isset($_GET['inactive'])) {
      $code = $_GET['inactive'];
        $update_sql= mysqli_query($connection,"UPDATE rider SET status='Inactive' WHERE code='$code'");
        header('location: ../rider_list?message_warning=User Access is restricted.',true,  302);
      }  
?>