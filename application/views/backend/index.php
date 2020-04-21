<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title ?></title>
    <?php 
    define("BASEASSET", base_url("assets/"));
    define("BASEADM", base_url("admin/"));
    define("PATHPAPI", str_replace('system', 'application', BASEPATH)); 
    ?>
    <link rel="shortcut icon" href="<?php echo BASEASSET ?>/images/favicon.ico" />
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo BASEASSET ?>/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo BASEASSET ?>/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="<?php echo BASEASSET ?>/vendors/dropzone/dropzone.css">
    <link rel="stylesheet" href="<?php echo BASEASSET ?>/css/demo_1/style.css">
    <link rel="stylesheet" href="<?php echo BASEASSET ?>/css/customBack.css">
    <link rel="stylesheet" type="text/css" href="<?= BASEASSET."vendors/datatables/css/datatables.min.css" ?>"/>
    <!-- Layout style -->
</head>
<body class="header-fixed" onload="initGeolocation()">

    <?php
    include PATHPAPI . "views/backend/layout/navbar.php";
    include PATHPAPI . "views/backend/layout/content.php";
    ?>
    <script>var BASEURL = '<?php echo BASEURL ?>'; var BASEADM = '<?php echo BASEADM ?>';</script>
    <script src="<?php echo BASEASSET ?>/vendors/js/core.js"></script>
    <script src="<?php echo BASEASSET ?>/js/jquery-3.3.1.min.js"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <script src="<?php echo BASEASSET ?>/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo BASEASSET ?>/vendors/chartjs/Chart.min.js"></script>
    <script src="<?php echo BASEASSET ?>/js/charts/chartjs.addon.js"></script>
    <script type="text/javascript" src="<?= BASEASSET."vendors/datatables/js/datatables.min.js" ?>"></script>
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="<?php echo BASEASSET ?>/js/dashboard.js"></script>
    <script src="<?= BASEASSET."vendors/datatables/js/dataTables.buttons.min.js"?>"></script>
    <script src="<?= BASEASSET."vendors/datatables/js/jszip.min.js"?>"></script>
    <script src="<?= BASEASSET."vendors/datatables/js/pdfmake.min.js"?>"></script>
    <script src="<?= BASEASSET."vendors/datatables/js/vfs_fonts.js"?>"></script>
    <script src="<?= BASEASSET."vendors/datatables/js/buttons.html5.min.js"?>"></script>
    <script src="<?php echo BASEASSET ?>/vendors/dropzone/dropzone.js"></script>
    <script src="<?php echo BASEASSET ?>/js/template.js"></script>
    <script src="<?php echo BASEASSET ?>/js/custom.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
    <script>
        var latitude = "0", longitude = "0";
        // Initialize and add the map
        function initGeolocation() {
            if (navigator.geolocation) {
                // Call getCurrentPosition with success and failure callbacks
                navigator.geolocation.getCurrentPosition(success, fail);
            }
            else {
                alert("Sorry, your browser does not support geolocation services.");
            }
        }

        function success(position) {
            console.log("lat "+position.coords.latitude);
            latitude = position.coords.latitude;
            document.cookie = "lat ="+ position.coords.latitude;
            document.cookie = "long ="+ position.coords.longitude;
            longitude = position.coords.longitude;
            console.log("lat "+position.coords.longitude);
        }

        function fail() {
            // Could not obtain location
        }
        function initMap() {
            // The location of Uluru
            initGeolocation();
            var uluru = {lat: <?= ($data['latitude'] == null ? $_COOKIE['lat'] : $data['latitude']);?>, lng: <?= ($data['longitude'] == null ? $_COOKIE['long'] : $data['longitude']);?>};
            // The map, centered at Uluru
            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 15, center: uluru});
            // The marker, positioned at Uluru
            var marker = new google.maps.Marker({position: uluru, map: map});
            
        }
    //     var markers = [
    //     {
    //         "title": 'Alibaug',
    //         "lat": '18.641400',
    //         "lng": '72.872200',
    //         "description": 'Alibaug is a coastal town and a municipal council in Raigad District in the Konkan region of Maharashtra, India.'
    //     },
    //     {
    //         "title": 'Lonavla',
    //         "lat": '18.750000',
    //         "lng": '73.416700',
    //         "description": 'Lonavla'
    //     },
    //     {
    //         "title": 'Mumbai',
    //         "lat": '18.964700',
    //         "lng": '72.825800',
    //         "description": 'Mumbai formerly Bombay, is the capital city of the Indian state of Maharashtra.'
    //     },
    //     {
    //         "title": 'Pune',
    //         "lat": '18.523600',
    //         "lng": '73.847800',
    //         "description": 'Pune is the seventh largest metropolis in India, the second largest in the state of Maharashtra after Mumbai.'
    //     },
    //     {
    //         "title": 'Thane',
    //         "lat": '19.182800',
    //         "lng": '72.961200',
    //         "description": 'Thane'
    //     },
    //     {
    //         "title": 'Vashi',
    //         "lat": '18.750000',
    //         "lng": '73.033300',
    //         "description": 'Vashi'
    //     }
    // ];
    // window.onload = function () {
    //     var mapOptions = {
    //         center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
    //         zoom: 8,
    //         mapTypeId: google.maps.MapTypeId.ROADMAP
    //     };
    //     var infoWindow = new google.maps.InfoWindow();
    //     var latlngbounds = new google.maps.LatLngBounds();
    //     var geocoder = geocoder = new google.maps.Geocoder();
    //     var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    //     for (var i = 0; i < markers.length; i++) {
    //         var data = markers[i]
    //         var myLatlng = new google.maps.LatLng(data.lat, data.lng);
    //         var marker = new google.maps.Marker({
    //             position: myLatlng,
    //             map: map,
    //             title: data.title,
    //             draggable: true,
    //             animation: google.maps.Animation.DROP
    //         });
    //         (function (marker, data) {
    //             google.maps.event.addListener(marker, "click", function (e) {
    //                 infoWindow.setContent(data.description);
    //                 infoWindow.open(map, marker);
    //             });
    //             google.maps.event.addListener(marker, "dragend", function (e) {
    //                 var lat, lng, address;
    //                 geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
    //                     console.log(status);
    //                     if (status == google.maps.GeocoderStatus.OK) {
    //                         lat = marker.getPosition().lat();
    //                         lng = marker.getPosition().lng();
    //                         address = results[0].formatted_address;
    //                         alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + address);
    //                     }
    //                 });
    //             });
    //         })(marker, data);
    //         latlngbounds.extend(marker.position);
    //     }
    //     var bounds = new google.maps.LatLngBounds();
    //     map.setCenter(latlngbounds.getCenter());
    //     map.fitBounds(latlngbounds);
    // }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOSKJIGO-yzFVyqEEzljduSDeVj0Z4_lo&callback=initMap">
    </script>
    <!-- endbuild -->
    
</body>
</html>