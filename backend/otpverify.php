<?php
session_start();
require 'connection.php';
?>
<?php
        if(isset($_SESSION['email'])&& isset($_SESSION['otp']) && isset($_SESSION['authentication']) && isset($_SESSION['position']) ){
            if( isset($_POST['token']) ){
                if($_POST['token']==$_SESSION['csrf_token'] ){
                $max_time=60*5;                     // csrf token time set
                $token_time=$_SESSION['csrf_time'];
                if($token_time + $max_time >= time()){
          
                    if(isset($_POST['verify']) && $_SESSION['position'] =='user' )
                    {
                        
                        $email=$_SESSION['email'];
                        $otpvalue=$_POST['otp'];
                        $otpvalue=stripcslashes($otpvalue);
                        $otpvalue=mysqli_real_escape_string($connection,$otpvalue);
                        $otpvalue=htmlspecialchars($otpvalue);

                        if(is_numeric($otpvalue)){
                            $query = "SELECT otp,authentication FROM user WHERE email=?";
                            $stmt = $connection->prepare($query); 
                            $stmt->bind_param("s", $email);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                
                            if($row['otp']== $otpvalue)
                            {
                                $verified="Verified";
                                $verified_sql = "UPDATE user SET authentication ='$verified'  WHERE email = '$email' ";
                                $verfied_result=mysqli_query($connection,$verified_sql);
                                
                                if($verfied_result=== TRUE ){
                                    session_unset();
                                    session_destroy();
                                    header("Location: ../index.php");
                                    exit();
                                }
                            }else{
                                echo "Invalid OTP. please write corrently";
                            }
                        }
                        else{
                            echo "Invalid OTP. please write corrently";
                        }
                        
                    }
                
                    elseif(isset($_POST['verify']) && $_SESSION['position'] =='rider' )
                    {
                        
                        $email=$_SESSION['email'];
                        $otpvalue=$_POST['otp'];
                        $otpvalue=stripcslashes($otpvalue);
                        $otpvalue=mysqli_real_escape_string($connection,$otpvalue);
                        $otpvalue=htmlspecialchars($otpvalue);

                        if(is_numeric($otpvalue)){
                            $query = "SELECT otp,authentication FROM rider WHERE email=?";
                            $stmt = $connection->prepare($query); 
                            $stmt->bind_param("s", $email);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            if($row['otp']== $otpvalue)
                            {
                                $verified="Verified";
                                $verified_sql = "UPDATE rider SET authentication ='$verified'  WHERE email = '$email' ";
                                $verfied_result=mysqli_query($connection,$verified_sql);
                                
                                if($verfied_result=== TRUE ){
                                    session_unset();
                                    session_destroy();
                                    header("Location: ../index.php");
                                    exit();
                                }
                            }else{
                                echo "Invalid OTP. please write corrently";
                            }
                        }
                        else{
                            echo "Invalid OTP. please write corrently";
                        }
                            
                    }
                    //----------------- end of else if part--------------
                    
                }else{
                    unset($_SESSION['csrf_token']);
                    unset($_SESSION['csrf_time']);
                    echo "Submission Timeout. please try again.";
                }
            }else{
                echo "Something worng with OTP validation. Please try again. ";
            }
        }
        }else{
            header("Location: ../index.php");
        }

        // resend 
        
        if(isset($_POST['resend']) && $_SESSION['position']=='user')
        {
            $otp=rand(100000, 999999);
            $_SESSION['otp']=$otp;
            $_SESSION['position']='user';
            $email=$_SESSION['email'];

            $sql = "UPDATE user SET otp='$otp' WHERE email='$email'";
            $connection->query($sql);
            include 'otpsend.php';
        }
        elseif(isset($_POST['resend']) && $_SESSION['position']=='rider')
        {
            $otp=rand(100000, 999999);
            $_SESSION['otp']=$otp;
            $_SESSION['position']='rider';
            $email=$_SESSION['email'];

            $sql = "UPDATE rider SET otp='$otp' WHERE email='$email'";
            $connection->query($sql);
            include 'otpsend.php';
        }     
        
    ?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styleverify.css">
    <title>otp verify</title>
</head>
<body>
    <?php
    // csrf token
    $token=md5(uniqid(rand(), true));
    $_SESSION['csrf_token']=$token;
    $_SESSION['csrf_time']=time();
  
    ?>
    <form class="form" action="otpverify.php" method="post" >
    <input type="hidden" name="token" value="<?=$token?>">      <!-- token-->
        <h1 class="login-title">Otp Verify</h1>
        <p>we send confirmation code.please check your email</p>
        <input type="text" maxlength="6" size="6" class="login-input" name="otp" placeholder="otp number" autofocus="true" />
        <input type="submit" value="Verify" name="verify" style="margin-bottom: 10px" class="login-button"/>
        <input type="submit" value="Resend" name="resend" class="login-button"/>
    </form>


    
</body>
</html>