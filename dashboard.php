<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Home</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
  
<?php
if (isset($_SESSION['id']) && isset($_SESSION['name'])&& isset($_SESSION['email'])&& isset($_SESSION['code'])&& isset($_SESSION['position'])&& isset($_SESSION['status'])) {
include 'backend/connection.php';
$city_select=mysqli_query($connection,"SELECT city FROM city");
include 'components/head.php';?>
<link rel="stylesheet" href="assets/css/style.css">
<?php include 'components/user_navbar.php'?>
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
      Dashboard
    </div>
</div>
      <div class="row">
      <div class="col-3">
         
         </div>
        <div class="col-6">
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
        <div class="card">
            <div class="card-body text-center">
              Welcome <?php echo $_SESSION['name'];?><br>
              Staus: <?php echo  $_SESSION['status'];?><br>
              Position: <?php echo  $_SESSION['position'];?><br>
            </div>
          </div>
        </div>
        <div class="col-3">
         
        </div>
      </div>
    </div><br>
    <div class="row">
      <div class="col-2">
         
         </div>
        <div class="col-8">
        <div class="card">
            <div class="card-body">
            <h2 class="card-title text-center">Please select your location to find vehicle</h2>
        <form action="search"  method="POST" >
            <div class="row">
              <div class="col">
              <label for="from">From:</label>
              <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="from" name="from">
                <?php foreach($city_select as $key => $value){ ?>
                <option value="<?= $value['city'];?>"><?= $value['city'];?></option>
                <?php } ?>
              </select>
              </div>
              <div class="col">
              <label for="to">To:</label>
              <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="to" name="to">
                <?php foreach($city_select as $key => $value){ ?>
                <option value="<?= $value['city'];?>"><?= $value['city'];?></option>
                <?php } ?>
              </select>
              </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
              <button class="btn btn-outline-success" type="submit" id="search" name="search" style="border-radius: 20px;">Search offer</button>
            </div>
          </form>
            </div>
          </div>
        </div>
        <div class="col-2">
         
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
}
else{
     header("Location: login");
     exit();
}
 ?>