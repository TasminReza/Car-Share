<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])&& isset($_SESSION['email'])&& isset($_SESSION['position'])&& isset($_SESSION['status'])) {
include 'backend/connection.php';
include 'components/head.php';
$query ="SELECT book.id as bookingid,book.*,DATE(book.datetime) as book_date, post.*,vehicle.*,rider_details.*,rider_details.code AS rider_code,rider_details.name AS driver,
rider_details.contact AS drivercno,user_details.*,user_details.code AS user_code, user_details.name AS username,user_details.contact AS user_cno FROM book 
INNER JOIN post ON book.vehicle_plate = post.vehicle_plate
INNER JOIN vehicle ON post.vehicle_plate = vehicle.plate_no
INNER JOIN rider_details ON vehicle.author_code = rider_details.code 
INNER JOIN user_details ON book.booked_by =user_details.code ORDER BY book.id DESC"; 
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
      Dashboard
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
        <?php if (isset($_GET['message_danger'])) { ?>
    <div class="alert alert-danger" role="alert">
      <h4 class="alert-heading">Successful</h4>
      <hr>
      <p><?php echo $_GET['message_danger']; ?></p>
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
            <h2 class="card-title text-center">Pending Booking Approval</h2>
            <input class="form-control me-2" id="search" type="search" placeholder="Search" aria-label="Search">
            <div class="table-responsive">
            <table class="table table-hover">
            <thead>
              <tr>
              <th scope="col">Rider Serial</th>
                <th scope="col">Vehicle Image</th>
                <th scope="col">Vehcle Model</th>
                <th scope="col">Plate No</th>
                <th scope="col">Driver</th>
                <th scope="col">Driver contact</th>
                <th scope="col">Booked By</th>
                <th scope="col">User Serial</th>
                <th scope="col">User Contact</th>
                <th scope="col">Journey Date</th>
                <th scope="col">Seat Booked</th>
                <th scope="col">Remaining Seat</th>
                <th scope="col">Travel Route</th>
                <th scope="col">Fare</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
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
                <td><?php echo $row['rider_code']?></td>
                  <td><img src="uploads/<?php echo $row['image']?>" class="img-thumbnail" width="80px" height="80px" alt="<?php echo $row['model']?>"></td>
                  <td><?php echo $row['vehicle_plate']?></td>
                  <td><?php echo $row['model']?></td>
                  <td><?php echo $row['driver']?></td>
                  <td><?php echo $row['drivercno']?></td>
                  <td><?php echo $row['username']?></td>
                  <td><?php echo $row['user_code']?></td>
                  <td><?php echo $row['user_cno']?></td>
                  <td><?php echo $row['jurney_date']?></td>
                  <td><?php echo $row['seat_booked']?></td>
                  <td><?php echo $row['seat']?></td>
                  <td><?php echo $row['from_loc']?> -> <?php echo $row['to_loc']?></td>
                  <td><?php echo $row['total']?></td>
                  <td>
                  <?php $approvel = $row['approvel'];
                      if($approvel === 'Unapproved'){?>
                      <span class="btn btn-warning btn-sm"><?php echo $row['approvel']?></span>
                      <?php }
                      elseif($approvel === 'Approved'){?>
                      <span class="btn btn-primary btn-sm"><?php echo $row['approvel']?></span>
                      <?php }
                      else{?>
                      <span class="btn btn-info btn-sm"><?php echo $row['approvel']?></span>
                      <?php }?>
                  </td>
                  <td><?php $approvel = $row['approvel'];
                   if($approvel === 'Approved' or $approvel === 'Unapproved'){
                      if($approvel === 'Unapproved'){?>
                    <a href="backend/book_confirmation?apporve=<?php echo $row['bookingid']?>" class="btn btn-primary"style="border-radius: 20px;">Approve</a>
                    <?php }
                      else{?>
                       <a href="backend/book_confirmation?unapprove=<?php echo $row['bookingid']?>" class="btn btn-warning"style="border-radius: 20px;">Unapprove</a>
                      <?php }
                       }
                      else{?>
                     
                     <?php }?>
                  </td>
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