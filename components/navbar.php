<div class="topnav" id="myTopnav">
  <a href="index" class="active">Ride Share System</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
  <svg viewBox="0 0 100 80" width="40" height="10">
  <rect width="100" height="20"></rect>
  <rect y="30" width="100" height="20"></rect>
  <rect y="60" width="100" height="20"></rect>
</svg>
  </a>
</div>
<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>