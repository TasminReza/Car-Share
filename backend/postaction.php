<?php 
session_start();
require 'connection.php';

if(isset($_POST['postoffer'])){
  if(isset($_POST['token']) ){
    if($_POST['token']==$_SESSION['csrf_token']){
      $max_time=60*5;                     // token time set
      $token_time=$_SESSION['csrf_time'];
      if($token_time + $max_time >= time()){
        $from_loc=htmlspecialchars($_POST['from']);
        $to_loc=htmlspecialchars($_POST['to']);
        $plate=htmlspecialchars($_POST['plate']);
        $journey_date=htmlspecialchars($_POST['date']);
        $seat=htmlspecialchars($_POST['seat']);
        $price_per_seat = htmlspecialchars($_POST['price_per_seat']);
        $authorcode =htmlspecialchars( $_POST['authorcode']);
      
        $vehicle_sql="INSERT INTO post(from_loc,to_loc,vehicle_plate,jurney_date,seat,price_per_seat,author_code)VALUE(?,?,?,?,?,?,?)";
        $stmt=$connection->prepare($vehicle_sql);  
        
        $stmt->bind_param("sssssss",$from_loc, $to_loc, $plate,$journey_date,$seat,$price_per_seat,$authorcode);
        if($stmt->execute()) {
          header("Location: ../rent_post?message_success= Your offer posted successfully.",true,  302 );
          exit;
        }else {
          header("Location: ../rent_post?message_failed= Could not post your Offer.",true,  302 );
          exit;
        }
      }else{
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_time']);
        header("Location: ../rent_post?message_failed= Offer post time expried. Please try again",true,  302 );
      exit;
      }
      
    }else{
      header("Location: ../rent_post?message_failed= Problem to post an offer. Please try Again",true,  302 );
      exit;
    }
  }else{
    header("Location: ../rent_post?message_failed=  Problem to post an offer. Please try Again",true,  302 );
    exit;
  }
}else {
  header("Location: ../rent_post?message_failed= Server taking too long to respond.",true,  302 );
      exit;
}
?>