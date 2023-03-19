<?php
session_start();
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Registration</title>
</head>
<body>
<form class="form" action="admin_registration.php" method="post">
    <h1 class="login-title">Registration</h1>
    <input type="text" class="login-input" name="username" placeholder="Username" required />
   
    <input type="Email" class="login-input" name="email" placeholder="Email Adress" required>
    <input type="password" minlength="8" maxlength="12" size="12" class="login-input" name="password" placeholder="Password" required>
    <input type="submit" name="submit" value="Register" class="login-button">
    <p class="link"><a href="index.php">Click to Login</a></p>
</form>

    <?php
        require 'connection.php';
        

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $username=htmlspecialchars($_POST['username']);
            $email=htmlspecialchars($_POST['email']);
            
            $password=$_POST['password'];
            $hash_password = hash('sha256',$password);


            $query="INSERT INTO admin (name,email,password) VALUES (?,?,?)";
            $stmt=$connection->prepare($query);

            $stmt->bind_param("sss", $username,$email,$hash_password);
            if($stmt->execute()){
                echo "Registration successfull";
            }
            else{
                echo "Registration Failed ".$connection->error;
            }



         }
        
    ?>

</body>
</html>