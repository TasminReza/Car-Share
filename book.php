<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking History</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
  
<?php

if (isset($_SESSION['id']) && isset($_SESSION['name'])&& isset($_SESSION['email'])&& isset($_SESSION['code'])&& isset($_SESSION['position'])&& isset($_SESSION['status'])) {
include 'backend/connection.php';
$vehicle = $_GET['confirmation'];
$from_loc=$_GET['from_loc'];
$to_loc=$_GET['to_loc'];
$query ="SELECT post.*,DATE(post.datetime) as postdate,vehicle.* FROM post JOIN vehicle ON post.vehicle_plate = vehicle.plate_no WHERE vehicle.vehicle_id='$vehicle' AND post.from_loc='$from_loc' AND post.to_loc='$to_loc' ";  
$result = mysqli_query($connection, $query);
include 'components/head.php';?>
<link rel="stylesheet" href="assets/css/style.css">
<?php include 'components/user_navbar.php';?>
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
    <a href="dashboard">Dashboard</a>: Offer
    </div>
</div>
      <div class="row">
      <div class="col-3">
         
         </div>
        <div class="col-6">
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
            <?php while($row = mysqli_fetch_array($result))  {?>
              <div class="card mb-3" >
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="uploads/<?php echo $row['image']?>" class="img-fluid rounded-start" alt="<?php echo $row['model']?>">
                  </div>
                  <div class="col-md-8" style="background-color: #04AA6D;color:white">
                      <h5 class="card-title"><?php echo $row['model']?></h5>
                      <p class="card-text"><?php echo $row['con']?></p>
                      <ul class="list-group list-group-flush" >
                    <li class="list-group-item">Plate No: <?php echo $row['plate_no']?></li>
                    <li class="list-group-item">Mileage: <?php echo $row['mileage']?></li>
                    <li class="list-group-item">Color: 
                    <div style="border:1px dashed #04AA6D;height: 50px;width: 50px;background-color: <?php echo $row['color']?>;"></div>
                  </li>
                  <li class="list-group-item"><span style="color: #4257f5;">From:</span> -> <span style="color: #32b1c7;">To:</span><br>
                  <span style="color: #4257f5;"><?php echo $row['from_loc']?></span> -> <span style="color: #32b1c7;"><?php echo $row['to_loc']?></span></li>
                  <li class="list-group-item">Total Seat: <?php echo $row['seat']?></li>
                  <li class="list-group-item">Fare Per Seat: <?php echo $row['price_per_seat']?></li>
                  <li class="list-group-item">Journey Date: <?php echo $row['jurney_date']?></li>
                  </ul>
                      <p class="card-text"><small>Added At: <?php echo $row['postdate']?></small></p>
                    </div>
                  </div>
                </div>
                <?php
                  // csrf token
                  $token=md5(uniqid(rand(), true));
                  $_SESSION['csrf_token']=$token;
                  $_SESSION['csrf_time']=time();
                ?>
        <form action="backend/proccss"  method="POST" >
          <input type="hidden" name="token" value="<?=$token?>">      <!-- token-->
                    <div class="row">
                <div class="col">
                <input type="text" class="form-control form-sm" value="<?php echo $_SESSION['code']?>" id="booking_author"name="booking_author" hidden>
                <input type="text" class="form-control form-sm" value="<?php echo $row['plate_no']?>" id="vehicle_plate"name="vehicle_plate" hidden>
                <input type="text" class="form-control form-sm" value="<?php echo $row['vehicle_id']?>" id="vehicle_id"name="vehicle_id" hidden>
                <input type="text" class="form-control form-sm" value="<?php echo $row['seat']?>" id="total_seat"name="total_seat" hidden>
                <input type="text" class="form-control form-sm" value="<?php echo $row['price_per_seat']?>" id="per_seat"name="per_seat" hidden>
                <label for="seat_book" class="col-sm-2 col-form-label">Seat to book</label>
                  <input type="number" class="form-control form-sm" min="1" max="<?php echo $row['seat']?>" id="seat_book"name="seat_book">
                </div>
            <div class="d-grid gap-2 col-6 mx-auto">
              <button class="btn btn-outline-success" type="submit" id="book" name="book" style="border-radius: 20px;">Book</button>
            </div>
            </div>
          </form>
          </div>
          <?php }?>
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
}else{
     header("Location: login");
     exit();
}
 ?>