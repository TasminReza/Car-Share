<?php
session_start();
    $email=$_SESSION['email'];
    $otp=$_SESSION['otp'];
        require '../phpmailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;                              

        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                              
              
        $mail->Username = '';                 //your email
        $mail->Password = '';                       // your email less secure password 
        $mail->SMTPSecure = 'tls';                            
        $mail->Port = 25;                                    

        $mail->setFrom('msiam183036@bscse.uiu.ac.bd', 'Minhajul Islam Siam');
        $mail->addAddress($email);            
        $mail->isHTML(true);                                  

        $mail->Subject = 'Confirm your email address';
        $mail->Body    = "Please verify your email with this given OTP"."<br>"."Your OTP is: <b>".$otp."</br> " ;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            header( "Location: otpverify.php" );
        }

    ?>