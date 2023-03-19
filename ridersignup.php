<?php 
session_start();
include 'components/head.php';?>
<link rel="stylesheet" href="assets/css/style.css">
<?php include 'components/navbar_secondary.php';?>
<body>
  <!------------------------------>
  <section id="features" class="features">
  <div class="row feature-icons">
    <h3 style="color:#2047EF;">Sign up here and start your ride</h3>
    <div class="container">
  <div class="row">
    <div class="col">
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
    <?php
    // csrf token
      $token=md5(uniqid(rand(), true));
      $_SESSION['csrf_token']=$token;
      $_SESSION['csrf_time']=time();
    ?>
    <div class="card mb-3"style="box-shadow:  -20px 20px 60px #bebebe,
             20px -20px 60px #ffffff;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="assets/img/pricing-business.png" width="260px" height="460px">
    </div>
    <div class="col-md-8" style="background-color:#2047EF;color:white;">
      <div class="card-body">
        <h2 class="card-title">Please input appropriate Info</h2>
        <form action="backend/signuprider"  method="POST">
        <input type="hidden" name="token" value="<?=$token?>">      <!-- token-->
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="nid" name="nid" placeholder="Enter your National ID number" required>
        </div><br>
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" placeholder="Enter your Firstname" required>
        </div><br>
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" placeholder="Enter your Lastname" required>
        </div><br>
        <div class="form-group">
          <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Enter your Email" required>
        </div><br>
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="contact" name="contact" placeholder="Enter your Contact number" required>
        </div><br>
        <div class="form-group">
          <input type="text" class="form-control form-control-sm" id="addrees" name="addrees" placeholder="Enter your Address" required>
        </div><br>
        <div class="form-group">
          <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter your Password" required>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" onclick="seepass()">
          <label class="form-check-label">See password</label>
        </div>
        <div class="g-recaptcha" data-sitekey=""></div>   <!-- recapcha -->
        <button type="submit" name="ridersignup" id="ridersignup" class="btn btn-info" style="border-radius: 15px;">Register Rider</button>
      </form>
      </div>
    </div>
  </div>
</div>
    </div>
    <div class="col">
     
    </div>
  </div>
</div>
</div>
</section>
<script>
  function seepass() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
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
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </body>
</html>