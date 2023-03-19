<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vehicale Registration</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
  
<?php
if (isset($_SESSION['id']) && isset($_SESSION['name'])&& isset($_SESSION['email'])&& isset($_SESSION['code'])&& isset($_SESSION['position'])&& isset($_SESSION['status'])) {
include 'backend/connection.php';
include 'components/head.php';?>
<link rel="stylesheet" href="assets/css/style.css">
<?php include 'components/rider_navbar.php';?>
<body>
  <!-- Log out -->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header"style="background-color:#FFE7A1">
        <h2 class="modal-title" id="logoutModalLongTitle">Log out</h2>
      </div>
      <div class="modal-body text-center"style="background-color:#FFE7A2;">
      <h4 >Are you sure want to log out, <?php echo $_SESSION['name'];?>?</h4>
      </div>
      <div class="modal-footer"style="background-color:#FFE7A1">
          <a href="backend/logout"><button type="button" class="btn btn-sm btn-warning text-white">Yes</button></a>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>

<!----------------------------------------------------------------------------->
<div class="row">
    <div class="col-sm-3">
      <a href="riderdashboard">Dashboard</a>: Vehicle Registration
    </div>
</div>
<div class="row">
    <div class="col-2">
      
    </div>
    <div class="col-8">
       <!------------------------------>
    <?php if (isset($_GET['message_failed'])) { ?>
    <div class="alert alert-warning" role="alert">
      <h4 class="alert-heading">Sorry</h4>
      <hr>
      <p><?php echo $_GET['message_failed']; ?></p>
    </div>
    <?php } ?>
    <!----------------------------->
    <!------------------------------>
    <?php if (isset($_GET['message_success'])) { ?>
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Successful</h4>
      <hr>
      <p><?php echo $_GET['message_success']; ?></p>
    </div>
    <?php } ?>
    <!----------------------------->
    <?php
        // csrf token
        $token=md5(uniqid(rand(), true));
        $_SESSION['csrf_token']=$token;
        $_SESSION['csrf_time']=time();
      ?>
      <div class="row">
        <div class="card">
            <div class="card-body">
            <h2 class="card-title text-center">Please input appropriate Info about your vehicle </h2>
            
        <form action="backend/vehiclereg"  method="POST" enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?=$token?>">      <!-- token-->
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="mileage" name="mileage" placeholder="Enter total Mileage of your vehicle" required>
        </div><br>
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="plate" name="plate" placeholder="Plate No" required>
        </div><br>
        <div class="form-group">
          <textarea type="text" class="form-control form-control-sm" id="condition" name="condition" placeholder="Condition" required></textarea>
        </div><br>
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="model" name="model" placeholder="Enter Model" required>
        </div><br>
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="authorcode" name="authorcode" value="<?php echo  $_SESSION['code'];?>" hidden readonly>
        </div><br>
        <div class="form-group">
        <label for="exampleColorInput" class="form-label">Choose your vehicle color</label>
        <input type="color" class="form-control form-control-color" id="color" name="color" value="#563d7c" title="Choose your color">
        </div>
        <div class="form-group">
        <label for="formFile" class="form-label">Upload an image of your vehicle:</label>
        <input type="file" name="file"><br>
        <button type="submit" name="vehiclereg" id="vehiclereg" class="btn btn-info" style="border-radius: 15px;">Register your vehicle</button>
      </form>
            </div>
        </div>
        <div class="col-sm-2">
         
        </div>
      </div>
    </div>
  <!------------------------------>
  <link rel="stylesheet" href="assets/css/style.css">
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/js/main_bootstrap.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
<?php 
}else{
     header("Location: login");
     exit();
}
 ?>