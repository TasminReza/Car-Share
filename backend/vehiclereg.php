<?php 
session_start();
require 'connection.php';
if(isset($_POST['vehiclereg'])){
  if(isset($_POST['token']) ){
   
    if($_POST['token']==$_SESSION['csrf_token']){
      $max_time=60*5;                     // token time set
      $token_time=$_SESSION['csrf_time'];
      if($token_time + $max_time >= time()){

        $query_vehicle="SELECT vehicle_id From vehicle ORDER BY vehicle_id DESC";
        $result=  mysqli_query($connection,$query_vehicle);
        $row= mysqli_fetch_array($result);
        $lastid=$row['vehicle_id'];
        if(empty($lastid)){
          $codevehicle= "Vehicle-0000001";
        }else{
          $id=str_replace("Vehicle-","",$lastid);
          $id=str_pad($id+1,7,0, STR_PAD_LEFT);
          $codevehicle ="Vehicle-" .$id;
        }
        
        $mileage=htmlspecialchars($_POST['mileage']);
        $vehicleid=$codevehicle;
        $plate=htmlspecialchars($_POST['plate']);
        $condition=htmlspecialchars($_POST['condition']);
        $model = htmlspecialchars($_POST['model']);
        $color =htmlspecialchars( $_POST['color']);
        $authorcode = htmlspecialchars($_POST['authorcode']);
        
        $pname = rand(1000,10000)."-".$_FILES["file"]["name"];
        $tname = $_FILES["file"]["tmp_name"];
        $uploads_dir = '../uploads';
        move_uploaded_file($tname, $uploads_dir.'/'.$pname);

        $query = "SELECT * FROM vehicle WHERE plate_no=? ";   // check already registered or not
        $stmt = $connection->prepare($query); 
        $stmt->bind_param("s", $plate);
        $stmt->execute();

        $result = $stmt->get_result();
        $count = $result->num_rows;
      
        if($count === 1){
          header("Location: ../vehicle_registration?message_failed= $plate is already registered.",true,  302 );
          exit();
        }else{
          $vehicle_sql="INSERT INTO vehicle(mileage,vehicle_id,plate_no,con,model,color,image,author_code)VALUE(?,?,?,?,?,?,?,?)";
          $stmt=$connection->prepare($vehicle_sql);  
      
          $stmt->bind_param("ssssssss",$mileage, $vehicleid, $plate,$condition,$model,$color,$pname,$authorcode);
          if($stmt->execute()){
            header("Location: ../vehicle_registration?message_success= Vehicle registered successfully.",true,  302 );
            exit;
          }else {
            header("Location: ../vehicle_registration?message_failed= Could not add your Vehicle.",true,  302 );
            exit;
          }
        }

        //----------else part end------------------
      }else{
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_time']);
        header("Location: ../vehicle_registration?message_failed= Vehicle registration time expried. please try again",true,  302 );
      exit;
      }
      
    }else{
      header("Location: ../vehicle_registration?message_failed= Problem with vehicle . Please try Again",true,  302 );
      exit;
    }
  }else{
    header("Location: ../vehicle_registration?message_failed= Problem with vehicle registation. Please try Again",true,  302 );
    exit;
  }

}else {
  header("Location: ../ridersignup?message_failed= Server taking too long to respond.",true,  302 );
      exit;
}
?>