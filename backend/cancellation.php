<?php require 'connection.php';
	if (isset($_GET['id'])) {
    $vehicle_plate = $_GET['id'];
    $bookingid=$_GET['bookingid'];

      $result=mysqli_query($connection,"SELECT * FROM book WHERE id='$bookingid'");
      $result_2=mysqli_query($connection,"SELECT * FROM post WHERE vehicle_plate='$vehicle_plate'");
      $booked=mysqli_fetch_assoc($result);
      $post=mysqli_fetch_assoc($result_2);
      $seat_book=$booked['seat_booked'];
      $booked_by=$booked['booked_by'];
      $posted_seat=$post['seat'];
      $final_seat = $posted_seat+$seat_book;
      $insert_cancellation=mysqli_query($connection,"INSERT INTO cancelled_trip(user_id,vehicle_plate)VALUE('$booked_by','$vehicle_plate')");

      $update_sql="UPDATE post SET 	seat=? WHERE vehicle_plate=?";
      $up_stmt= $connection->prepare($update_sql);
      $up_stmt->bind_param("ss", $final_seat, $vehicle_plate);
      $up_stmt->execute();

      $delete_sql="DELETE FROM book WHERE id=?";
      $del_stmt = $connection->prepare($delete_sql);
      $del_stmt->bind_param('s', $bookingid);
      $del_stmt->execute();
      header('location: ../booking_history?message_success= Booking removed successfully.',true,  302);
    }  
?>