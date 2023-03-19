<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
  
<?php
if (isset($_SESSION['id']) && isset($_SESSION['name'])&& isset($_SESSION['email'])&& isset($_SESSION['code'])&& isset($_SESSION['position'])&& isset($_SESSION['status'])) {
require 'backend/connection.php';
  if(isset($_POST['search'])){
    $serached_from= $_POST['from'];
    $serached_to= $_POST['to'];
    $query ="SELECT post.*,DATE(post.datetime) as postdate,vehicle.*,rider.status FROM post
    INNER JOIN vehicle ON post.vehicle_plate = vehicle.plate_no 
    INNER JOIN rider ON rider.code = vehicle.author_code 
     WHERE post.from_loc='$serached_from' AND post.to_loc='$serached_to' AND post.jurney_date IN(curdate(),curdate() + interval 1 day) AND post.seat >0 AND vehicle.status='Active' AND rider.status='Active' ORDER BY post.jurney_date ASC";  
 $result = mysqli_query($connection, $query); 
  }
  ?>
 <?php include 'components/head.php';?>
<link rel="stylesheet" href="assets/css/style.css">
<?php include 'components/user_navbar.php';?>
<script src="assets/js/jquery-3.5.1.slim.min.js"></script>
<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tableDetails tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
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
<div class="col-2">
      
      </div>
    <div class="col-8">
      <div class="row">
        <div class="card">
            <div class="card-body">
            <h2 class="card-title text-center">Your  Offer </h2>
           <input class="form-control me-2" id="search" type="search" placeholder="Search" aria-label="Search"> 
            <div class="table-responsive">
            <table class="table table-hover">
              <tbody id="tableDetails">
              <?php 
              if(mysqli_num_rows($result) === 0){?>
              <tr>
                <td class="text-center text-danger">No Post Offered</td> 
              </tr>
                <?php }
                else{
                  while($row = mysqli_fetch_array($result))  {?>
                <tr>
                <td>
                <div class="card mb-3" >
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="uploads/<?php echo $row['image']?>" class="img-fluid rounded-start" alt="<?php echo $row['model']?>">
                  </div>
                  <div class="col-md-8" style="background-color: #04AA6D;color:white">
                    <div class="card-body" >
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
                      <a href="book?confirmation=<?php echo $row['vehicle_id']?>&from_loc=<?php echo $serached_from; ?> &to_loc=<?php echo $serached_to; ?>" class="btn btn-primary"style="border-radius: 20px;">Book</a>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            </tr>
                <?php }
                }?>
              </tbody>
           </table>
          </div>
            </div>
            <div class="col-2">

      </div>
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
  <?php 
}else{
     header("Location: login");
     exit();
}
 ?>