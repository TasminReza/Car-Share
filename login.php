<?php 
session_start();

include 'components/head.php';?>
  <!-- Main CSS File -->
  <link rel="stylesheet" href="assets/css/main.css">
<body>
<section class="showcase">
    <header>
      <h2 class="logo">Welcome to Ride Share System</h2>
      <div class="toggle"></div>
    </header>
    <video src="assets/videos/video.mp4" muted loop autoplay></video>
    <div class="overlay"></div>
    <div class="text">
      <h2>In A Hurry?</h2> 
      <h4>Just Log in here and select your ride</h4>
      <!----------------------------->
      <?php if (isset($_GET['message_success'])) { ?>
      <div class="card" style="background-color: #1D8961; color:white;">
      <div class="card-body">
        <h4 class="card-title">Success</h4>
        <hr>
        <p class="card-text"><?php echo $_GET['message_success']; ?></p>
      </div>
    </div>
    <?php } ?>
      <div class="card" >
      <div class="card-body text-center">
        <!-------------------------------------------->
        <?php if (isset($_GET['disabled_msg'])) { ?>
        <div class="alert alert-danger " role="alert">
  <h4 class="alert-heading text-danger">Account Disabled! <i class="icofont-sad"></i>
  <p class="text-dark"><?php echo $_GET['disabled_msg']; ?></p>
  <hr>
  <p class="mb-0 text-info">Please contact with the Admin.</p>
</div>
<?php } ?>
      <!----------------------------->
      <?php if (isset($_GET['wanted'])) { ?>
      <div class="alert alert-warning" role="alert">
      <?php echo $_GET['wanted']; ?>
      </div>
      <?php } ?>
      <!----------------------------->
      <!----------------------------->
      <?php if (isset($_GET['error'])) { ?>
      <div class="alert alert-danger" role="alert">
      <?php echo $_GET['error']; ?>
      </div>
      <?php } ?>
      <!----------------------------->
      <?php
        // csrf token
        $token=md5(uniqid(rand(), true));
        $_SESSION['csrf_token']=$token;
        $_SESSION['csrf_time']=time();
      ?>
      <form action="backend/loginroute" method="post">
      <input type="hidden" name="token" value="<?=$token?>">      <!-- token-->
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="email" name="email"  placeholder="name@example.com">
        <label for="floatingInput">Enter your Email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <label for="floatingPassword">Enter your Password</label>
      </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" onclick="seepass()">
          <label class="form-check-label">See your password</label>
        </div>
        <div class="g-recaptcha" data-sitekey=""></div>          <!-- recapcha -->
        <button type="submit" class="button button1" name="login" id="login">Log in</button>
      </div>
      </form>
      <a href="#" class="card-link text-success" id="modalBtn">No account? Signup here</a>
    </div>
    </div>
    <!------------------------------------------>
    <div class="card" id="modal" style="display: none;width: 60rem;background-color:#04AA6D;">
  <div class="card-body">
  <span class="close"><i class="bi bi-x-circle" style="color: white;"></i></span>
  <div class="row">
  <div class="col-sm-6">
  <div class="card mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="assets/img/features-3.png" alt="user" width="100px" height="150px">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">User SignUP</h5>
        <p class="card-text">Click here to signup as user</p>
        <a href="usersignup" class="btn btn-success">Sign Up</a>
      </div>
    </div>
  </div>
</div>
  </div>
  <div class="col-sm-6">
  <div class="card mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
  <div class="col-md-4">
      <img src="assets/img/pricing-business.png" alt="rider" width="100px" height="150px">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Rider SignUP</h5>
        <p class="card-text">Click here to signup as Roder</p>
        <a href="ridersignup" class="btn btn-primary">Sign Up</a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
  </div>
  <!------------------------------------------>
</div>
  </section>
   <!-- Vendor JS Files -->
   <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/main_bootstrap.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
var modal = document.getElementById("modal");
var btn = document.getElementById("modalBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
function seepass() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</body>
</html>