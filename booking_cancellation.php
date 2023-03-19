<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])&& isset($_SESSION['email'])&& isset($_SESSION['position'])&& isset($_SESSION['status'])) {
include 'backend/connection.php';
include 'components/head.php';
$query ="SELECT cancelled_trip.*,DATE(cancelled_trip.datetime) as reg_date,user_details.*,vehicle.* FROM cancelled_trip 
INNER JOIN user_details ON cancelled_trip.user_id = user_details.code 
INNER JOIN vehicle on vehicle.plate_no = cancelled_trip.vehicle_plate
ORDER BY cancelled_trip.id ASC"; 
 $result = mysqli_query($connection, $query);?>
<link rel="stylesheet" href="assets/css/style.css">
<?php include 'components/navbar_dashboard.php';?>
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
    <a href="admin">Dashboard</a>: Booking Cancellation
    </div>
</div>
  <div class="row">
    <div class="col-sm-3">
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
        <!------------------------------>
        <?php if (isset($_GET['message_warning'])) { ?>
    <div class="alert alert-warning" role="alert">
      <h4 class="alert-heading">Successful</h4>
      <hr>
      <p><?php echo $_GET['message_warning']; ?></p>
    </div>
    <?php } ?>
    <!----------------------------->
    </div>
    <div class="col-sm-9">
      <div class="row">
        <div class="col-8 col-sm-6">
        <div class="card">
            <div class="card-body text-center">
              Welcome <?php echo $_SESSION['name'];?><br>
              Staus: <?php echo  $_SESSION['status'];?>
              Position: <?php echo  $_SESSION['position'];?><br>
            </div>
          </div>
        </div>
        <div class="col-2">
         
        </div>
      </div>
    </div>
  </div>
  <div class="row">
      
        <div class="col-12">
        <div class="card">
            <div class="card-body">
            <h2 class="card-title text-center">Booking Cancellation List</h2>
            <input class="form-control me-2" id="search" type="search" placeholder="Search" aria-label="Search">
            <div class="table-responsive">
            <table class="table table-hover">
            <thead>
              <tr>
              <th scope="col">Serial</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Contact</th>
                <th scope="col">NID</th>
                <th scope="col">Date of Registration</th>
                <th scope="col">Vehicle No</th>
                <th scope="col">Owner Code</th>
              </tr>
            </thead>
              <tbody id="tableDetails">
              <?php 
              if(mysqli_num_rows($result) === 0){?>
              <tr>
                <td class="text-danger text-center">There is no booking in our record</td> 
              </tr>
                <?php }
                else{
                  while($row = mysqli_fetch_array($result))  {?>
                <tr>
                <td><?php echo $row['code']?></td>
                  <td><?php echo $row['name']?></td>
                  <td><?php echo $row['email']?></td>
                  <td><?php echo $row['address']?></td>
                  <td><?php echo $row['contact']?></td>
                  <td><?php echo $row['nid']?></td>
                  <td><?php echo $row['reg_date']?></td>
                  <td><?php echo $row['plate_no']?></td>
                  <td><?php echo $row['author_code']?></td>
                </tr>
                <?php }
                }?>
              </tbody>
           </table>
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
  </body>
</html>
<?php 
}else{
     header("Location: login");
     exit();
}
 ?>