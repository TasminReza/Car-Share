<?php
session_start();

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['g-recaptcha-response']) && isset($_POST['token']) ){
  //csrf token validity check
  if($_POST['token']==$_SESSION['csrf_token']){
    $max_time=60*3;                     // token time set
    $token_time=$_SESSION['csrf_time'];
    if($token_time + $max_time >= time()){

      require 'connection.php';
      function validate_data($data){
        $data=trim($data);
        return($data);
      }
      $input_email= validate_data($_POST['email']);

      $input_password= validate_data($_POST['password']);
      $input_password=hash('sha256',$input_password);

      $secret=' ';       // recaptcha secrect key
      $response=$_POST['g-recaptcha-response'];             // recaptcha
      $remoteip=$_SERVER['REMOTE_ADDR'];
      $url="https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
      $data=file_get_contents($url);
      $json_row=json_decode($data);

      if(empty($input_email)){
        header("Location: ../login?wanted= Email is Required");
        exit();
      }elseif(empty($input_password)){
        header("Location: ../login?wanted= Password is Required");
        exit();
      }else{

        
      
        // Admin query
        $admin_query = "SELECT * FROM admin WHERE email=? AND password=? ";
        $stmt = $connection->prepare($admin_query);
        $stmt->bind_param("ss", $input_email,$input_password);
        $stmt->execute();
        $admin_result = $stmt->get_result();
        $admin_count = $admin_result->num_rows;
        

        // User Query
        $user_query = "SELECT * FROM user WHERE email=? AND password=? ";
        $stmt = $connection->prepare($user_query);
        $stmt->bind_param("ss", $input_email,$input_password);
        $stmt->execute();
        $user_result = $stmt->get_result();
        $user_count = $user_result->num_rows; 

        // Rider query
        $rider_query = "SELECT * FROM rider WHERE email=? AND password=? ";
        $stmt = $connection->prepare($rider_query); 
        $stmt->bind_param("ss", $input_email,$input_password);
        $stmt->execute();
        $rider_result = $stmt->get_result();
        $rider_count = $rider_result->num_rows;
        
        if($json_row->success==true){   // recaptcha json data
          if($admin_count ===1  ){ 
            $admin_row = $admin_result->fetch_assoc();  

            if( $admin_row['email'] ===$input_email && $admin_row['password']=== $input_password) {        
              $_SESSION['name'] = $admin_row['name'];
              $_SESSION['email'] = $admin_row['email'];
              $_SESSION['position'] = $admin_row['position'];
              $_SESSION['status'] = $admin_row['status'];
              $_SESSION['id'] = $admin_row['id'];
              header("Location: ../admin");
              exit();
            }
          }
          elseif($user_count ===1){
            $user_row = $user_result->fetch_assoc();

            if($user_row['authentication']!="unverified"){
              if($user_row['email'] === $input_email && $user_row['password']=== $input_password && $user_row['status'] === 'Active'){
                      $_SESSION['id'] = $user_row['id'];
                      $_SESSION['name'] = $user_row['name'];
                      $_SESSION['email'] = $user_row['email'];
                      $_SESSION['code'] = $user_row['code'];
                      $_SESSION['position'] = $user_row['position'];
                      $_SESSION['status'] = $user_row['status'];
                    header("Location: ../dashboard");
                  exit();
              }elseif($user_row['status'] === 'Inactive'){
                header("Location: ../login?disabled_msg= Your account has been Deactivated.");
                  exit();
                }
            }
            else{
            
              $_SESSION['email']=$user_row['email'];
              $_SESSION['otp']=$user_row['otp'];
              $_SESSION['position']=$user_row['position'];
              $_SESSION['authentication']=$user_row['authentication'];
              echo $_SESSION['position'];
            header("Location: otpverify.php");
            }
          }
          elseif($rider_count===1){
            $rider_row = $rider_result->fetch_assoc();

            if($rider_row['authentication']!="unverified"){
              if($rider_row['email'] === $input_email && $rider_row['password']=== $input_password && $rider_row['status'] === 'Active'){
                $_SESSION['id'] = $rider_row['id'];
                $_SESSION['name'] = $rider_row['name'];
                $_SESSION['email'] = $rider_row['email'];
                $_SESSION['code'] = $rider_row['code'];
                $_SESSION['position'] = $rider_row['position'];
                $_SESSION['status'] = $rider_row['status'];
                header("Location: ../riderdashboard");
                exit();
              }elseif($rider_row['status'] === 'Inactive'){
                header("Location: ../login?disabled_msg= Your account has been Deactivated.");
                exit();
                }
            }
            else{
              $_SESSION['email']=$rider_row['email'];
              $_SESSION['otp']=$rider_row['otp'];
              $_SESSION['authentication']=$rider_row['authentication'];
              $_SESSION['position']=$rider_row['position'];
              header("Location: otpverify.php");
            }
          }

          else{
            header("Location: ../login?error=Incorect email or password");
                exit();
          }
        }else{
          header("Location: ../login?error=Please check the recapcha");
              exit();
        }
      }
      //-------------- else part end -------------
    }else{
      unset($_SESSION['csrf_token']);
      unset($_SESSION['csrf_time']);
      header("Location: ../login?error=Login time out. please try again.");
      exit();
    }
  }else{
    header("Location: ../login?error=Problem with Login. please try again.");
        exit();
  }
}else{
  header("Location: ../login");
  exit();
}
?>