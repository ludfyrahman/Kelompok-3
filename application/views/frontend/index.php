<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <?php 
    define("BASEASSET", base_url("assets/"));
    define("BASEADM", base_url("admin/"));
    // define("BASEURL", base_url());
    define("PATHPAPI", str_replace('system', 'application', BASEPATH));
    // define('CLIENT_REDIRECT_URL', str_replace('system', 'application', BASEPATH).'helpers/gauth.php');
    ?>
    <link rel="icon" href="<?= BASEASSET ?>/images/favicon.png">
    <!-- ***** All CSS Files ***** -->

    <!-- Style css -->
    <link rel="stylesheet" href="<?=BASEASSET?>css/style.css">

    <!-- Responsive css -->
    <link rel="stylesheet" href="<?=BASEASSET?>css/responsive.css">
    <link rel="stylesheet" href="<?=BASEASSET?>css/custom.css">
    <link rel="stylesheet" href="<?php echo BASEASSET ?>/vendors/dropzone/dropzone.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <meta name="google-signin-client_id" content="<?= CLIENT_ID?>">
</head>
<body class="miami">
    <!--====== Preloader Area Start ======-->
    <div id="loader">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
    <!--====== Preloader Area End ======-->

    <!--====== Scroll To Top Area Start ======-->
    <div id="scrollUp" title="Scroll To Top">
        <i class="icofont-bubble-up"></i>
    </div>
    
    <!--====== Scroll To Top Area End ======-->
<?php
if($content != 'user/login')
    include PATHPAPI . "views/frontend/layout/navbar.php";

if($content == 'site/home')
    include PATHPAPI . "views/frontend/layout/header.php";

include PATHPAPI . "views/frontend/content/$content.php";
if($content != 'user/login')
    include PATHPAPI . "views/frontend/layout/footer.php";

?>

<script>var BASEURL = '<?php echo BASEURL ?>'; var BASEADM = '<?php echo BASEADM ?>';</script>
<script src="<?php echo BASEASSET ?>js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap js -->
<script src="<?php echo BASEASSET ?>vendors/bootstrap/popper.min.js"></script>
<script src="<?php echo BASEASSET ?>vendors/bootstrap/bootstrap.min.js"></script>

<!-- Plugins js -->
<script src="<?php echo BASEASSET ?>js/plugins.min.js"></script>

<!-- Active js -->
<script src="<?php echo BASEASSET ?>/vendors/dropzone/dropzone.js"></script>
<script src="<?php echo BASEASSET ?>js/script.js"></script>
<script src="<?php echo BASEASSET ?>/js/active.js"></script>


<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOSKJIGO-yzFVyqEEzljduSDeVj0Z4_lo&callback=initMap">
</script>
<script>
// Initialize and add the map
initGeolocation();
function initGeolocation() {
    console.log("berhasil");
   if (navigator.geolocation) {
      // Call getCurrentPosition with success and failure callbacks
      navigator.geolocation.getCurrentPosition(success, fail);
   }
   else {
      alert("Sorry, your browser does not support geolocation services.");
   }
}

function success(position) {
    document.cookie = "long="+position.coords.longitude;
    document.cookie = "lat="+position.coords.latitude;
   console.log("long " + position.coords.longitude);
   console.log("lat " + position.coords.latitude);
   // document.getElementById('long').value = position.coords.longitude;
   // document.getElementById('lat').value = position.coords.latitude;
}

function fail() {
    console.log("error");
   // Could not obtain location
}
function initMap() {
  // The location of Uluru
  var uluru = {lat: <?=(isset($data['latitude']) == null ? 0 : $data['latitude'])?>, lng: <?= (isset($data['longitude']) == null ? 0 : $data['longitude']) ?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 17, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
</script>



</body>
</html>