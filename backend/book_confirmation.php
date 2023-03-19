<?php 
require 'connection.php';
	if (isset($_GET['apporve'])) {
    $id = $_GET['apporve'];

    $update_sql= mysqli_query($connection,"UPDATE book SET approvel='Approved' WHERE id='$id'");
    header('location: ../admin?message_success= Booking Approved.',true,  302);
  }  
  if (isset($_GET['unapprove'])) {
      $id = $_GET['unapprove'];
      $update_sql= mysqli_query($connection,"UPDATE book SET approvel='Unapproved' WHERE id='$id'");
      header('location: ../admin?message_danger= Booking Unapproved.',true,  302);
  } 
?>