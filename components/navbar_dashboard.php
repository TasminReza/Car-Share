<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <a class="navbar-brand" href="#" style="background-color: #04AA6D;color:white;">Ride Share System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php $position= $_SESSION['position'];
        if($position==='Admin'){?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin">Dashboard</a>
        </li>
      </ul>
        <?php }
         elseif($position==='Rider'){?>
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="riderdashboard">Dashboard</a>
        </li>
      </ul>
          <?php }
        elseif($position==='User'){?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard">Dashboard</a>
        </li>
      </ul>
        <?php }?>
      
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" style="background-color: #016943;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        Hello <?php echo $_SESSION['name'];?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li class="dropdown-item" >
              Staus: <?php echo  $_SESSION['status'];?><br>
              Position: <?php echo  $_SESSION['position'];?><br>
        </li>
        <hr>
        <?php $position= $_SESSION['position'];
        if($position==='Admin'){?>
        <li><a class="dropdown-item" href="vehicle_approval">Vehicle approval</a></li>
        <li><a class="dropdown-item" href="user_list">User</a></li>
        <li><a class="dropdown-item" href="rider_list">Rider</a></li>
        <li><a class="dropdown-item" href="booking_cancellation">Booking Cancellation</a></li>
        <?php }
        elseif($position==='Rider'){?>
        <li><a class="dropdown-item" href="vehicle_registration">Register your vehicle</a></li>
        <li><a class="dropdown-item" href="vehicle">Your Vehicle</a></li>
        <li><a class="dropdown-item" href="rent_post">Post your offer</a></li>
          <?php }
        elseif($position==='User'){?>
         <li>
           <a class="dropdown-item" href="booking_history">Booking History 
             <?php $notification="SELECT * FROM book WHERE approvel ='Approved'";
             $notification_result=mysqli_query($connection,$notification);
             if(mysqli_num_rows($notification_result)===1){?>
           <span class="badge badge-light" style="border: radius 50px;background-color:#016943;color:white;">New</span>
           <?php }
           else{?>
           <?php }?>
          </a>
        </li>
        <?php }?>
          <li>
          <a class="dropdown-item" href="#"><button type="button" class="btn btn-outline-warning"style="color: #016468;border-radius: 25px" data-toggle="modal" data-target="#logout">Log Out <i class="icofont-logout"style="color: #016468;"></i></button></a>
          </li>
        </ul>
      </div>
    </div>
</nav>