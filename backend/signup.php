<?php 
session_start();

require 'connection.php';

  if(isset($_POST['usersignup'])  && isset($_POST['g-recaptcha-response']) ){
    
    //csrf token validity check
    if(isset($_POST['token']) ){
      if($_POST['token']==$_SESSION['csrf_token']){
        $max_time=60*5;                     // token time set
        $token_time=$_SESSION['csrf_time'];
        if($token_time + $max_time >= time()){

          $query_user="SELECT code From user_serial ORDER BY code DESC";
            $result=  mysqli_query($connection,$query_user);
            $row= mysqli_fetch_array($result);
            $lastid=$row['code'];
            if(empty($lastid)){
              $codeuser= "User-0000001";
            }else{
              $id=str_replace("User-","",$lastid);
              $id=str_pad($id+1,7,0, STR_PAD_LEFT);
              $codeuser ="User-" .$id;
            }
            
            $secret='';       //recaptcha serect key

            $response=$_POST['g-recaptcha-response'];             // recaptcha
            $remoteip=$_SERVER['REMOTE_ADDR'];
            $url="https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";   // check

            $data=file_get_contents($url);
            $json_row=json_decode($data);                       // recaptcha fetch data

            $nid= htmlspecialchars($_POST['nid']);
            $name=htmlspecialchars($_POST['firstname']. ' ' .$_POST['lastname']);
            $code=$codeuser;
            $email=htmlspecialchars($_POST['email']);
            $contact =htmlspecialchars($_POST['contact']);
            $address =htmlspecialchars($_POST['addrees']);

            $password =($_POST['password']);
            $encrypt_password = hash('sha256',$password);
            
            $position='user';
            $otp=rand(100000, 999999);
            $authentication="unverified";

            $query = "SELECT * FROM user WHERE email=? ";
            $stmt = $connection->prepare($query); 
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            $count = $result->num_rows;
            
            if($json_row->success==true){

              if($count === 1){

                header("Location: ../usersignup?message_failed= $email is already registered.Please try with another email",true,  302 );
                exit();
              }
              else{
                $details_sql="INSERT INTO user_details(code,name,email,nid,contact,address)VALUE(?,?,?,?,?,?)";
                $details_stmt=$connection->prepare($details_sql);
                $details_stmt->bind_param("ssssss",  $code, $name,$email,$nid,$contact,$address);

                if ($details_stmt->execute() === TRUE) {
                  $user_serial="INSERT INTO user_serial(code,name)VALUE(?,?)";
                  $user_stmt=$connection->prepare($user_serial);
                  $user_stmt->bind_param("ss",  $code, $name);

                  if ($user_stmt->execute() === TRUE) {
                    $login_user="INSERT INTO user(name,email,code,password,position,otp,authentication)VALUE(?,?,?,?,?,?,?)";
                    $login_stmt=$connection->prepare($login_user);
                    $login_stmt->bind_param("sssssss",  $name, $email,$code,$encrypt_password,$position,$otp,$authentication);

                    if ($login_stmt->execute() === TRUE) {
                      $_SESSION['otp']=$otp;
                      $_SESSION['position']=$position;
                      $_SESSION['email']=$email;
                      $_SESSION['authentication']=$authentication;
                            
                      header( "Location: otpsend.php" );
                      exit;
                    }else {
                      header("Location: ../usersignup?message_failed= Could not add your account.",true,  302 );
                      exit;
                    }
                  }else {
                    header("Location: ../usersignup?message_failed= Could not add your account.",true,  302 );
                    exit;
                  }
                }else {
                  header("Location: ../usersignup?message_failed= Could not add your account.",true,  302 );
                  exit;
                }
              }
          }else{
            header("Location: ../usersignup?message_failed= Please check the recapcha.",true,  302 );
            exit;
          }

        }else{
          unset($_SESSION['csrf_token']);
          unset($_SESSION['csrf_time']);
          header("Location: ../usersignup?message_failed=Login time expried.",true,  302 );
        exit;
        }
        
      }else{
        header("Location: ../usersignup?message_failed= Problem with registation. Please try Again",true,  302 );
        exit;
      }
  }else{
    header("Location: ../usersignup?message_failed= Problem with registation. Please try Again",true,  302 );
    exit;
  }
}else {
    header("Location: ../usersignup?message_failed= Server taking too long to respond.",true,  302 );
    exit;
}
?>