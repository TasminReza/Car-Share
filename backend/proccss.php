<?php 
session_start();
require 'connection.php';

if(isset($_POST['book'])){
  if(isset($_POST['token']) ){
    if($_POST['token']==$_SESSION['csrf_token']){
      $max_time=60*5;                     // token time set
      $token_time=$_SESSION['csrf_time'];
      if($token_time + $max_time >= time()){
        $seat_book = htmlspecialchars($_POST['seat_book']);
        $seat_price =htmlspecialchars( $_POST['per_seat']);
        $total_seat = htmlspecialchars($_POST['total_seat']);
        $vehicle_id = htmlspecialchars($_POST['vehicle_id']);
        $vehicle_plate = htmlspecialchars($_POST['vehicle_plate']);
        $booking_author = htmlspecialchars($_POST['booking_author']);
        $total_price= $seat_price* $seat_book;
        $remaining_seat=  $total_seat - $seat_book ;

        $update_sql="UPDATE post SET seat= ? WHERE 	vehicle_plate =?";
        $up_stmt= $connection->prepare($update_sql);
        $up_stmt->bind_param("ss", $remaining_seat, $vehicle_plate);
        if ($up_stmt->execute()) {
          
          $book_detail="INSERT INTO book(vehicle_id,vehicle_plate,seat_booked,total,booked_by)VALUE(?,?,?,?,?)";
          $stmt=$connection->prepare($book_detail);
          $stmt->bind_param("sssss",$vehicle_id, $vehicle_plate, $seat_book,$total_price,$booking_author);
          if($stmt->execute()) {
            header("Location: ../booking_history?message_success= Rent request submitted successfully.Please wait till admin approve your booking.",true,  302 );
            exit;
          }else {
            header("Location: ../booking_history?message_failed= Could not proceed your booking.",true,  302 );
                exit;
          }
        }else {
          header("Location: ../booking_history?message_failed= Could not proceed your booking.",true,  302 );
              exit;
        }
      }else{
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_time']);
        header("Location: ../booking_history?message_failed=Booking time expried. Please try again",true,  302 );
      exit;
      }
      
    }else{
      header("Location: ../booking_history?message_failed= Problem to book the seat. Please try Again",true,  302 );
      exit;
    }
  }else{
    header("Location: ../booking_history?message_failed= Problem to book the seat. Please try Again",true,  302 );
    exit;
  }
}else {
  header("Location: ../dashboard?message_failed= Server taking too long to respond.",true,  302 );
      exit;
}?>