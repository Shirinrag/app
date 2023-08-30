<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Dashboard</title>
      <!-- plugins:css -->
      <?php include 'common/cssfiles.php';?>
   </head>
   <body>
      <!-- <div class="container-scroller"> -->
         <!-- partial:partials/_navbar.html -->
         <?php include 'common/header.php';?>
         <!-- partial -->
         <div class="container-fluid page-body-wrapper">
           
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <?php include 'common/sidebar.php';?>
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">
                 
                  <div class="row">
                   
                     <!-- <div class="col-md-3 grid-margin transparent"> -->
                        <div class="row">
                           <div class="col-md-3 stretch-card transparent">
                              <div class="card card-tale">
                                 <div class="card-body">
                                    <p class="mb-4">Today’s User</p>
                                    <p class="fs-30 mb-2"><?=$total_user_count?></p>
                                  
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3 stretch-card transparent">
                              <div class="card card-dark-blue">
                                 <div class="card-body">
                                    <p class="mb-4">Total Bookings</p>
                                    <p class="fs-30 mb-2"><?=$total_booking_count?></p>
                                    
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3 mb-lg-0 stretch-card transparent">
                              <div class="card card-light-blue">
                                 <div class="card-body">
                                    <p class="mb-4">Total Place</p>
                                    <p class="fs-30 mb-2"><?=$total_place_count?></p>
                                    <!-- <p>2.00% (30 days)</p> -->
                                 </div>
                              </div>
                           </div>
                            <div class="col-md-3 stretch-card transparent">
                              <div class="card card-light-danger">
                                 <div class="card-body">
                                    <p class="mb-4">Downloads</p>
                                    <p class="fs-30 mb-2"><?=$total_download_count?></p>
                                   <!--  <p>0.22% (30 days)</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     <!-- </div> -->
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                     </div>
                     <div class="col-md-12">
                            <div style="width: 800px;"><canvas id="acquisitions"></canvas></div>
                     </div>
                     
                  </div>
               </div>
               <!-- content-wrapper ends -->
               <!-- partial:partials/_footer.html -->
               <?php include 'common/footer.php';?>
               <!-- partial -->
            </div>
            <!-- main-panel ends -->
         </div>
         <!-- page-body-wrapper ends -->
      <!-- </div> -->
      <!-- container-scroller -->
      <!-- plugins:js -->
      <?php include 'common/jsfiles.php';?>
      <script type="text/javascript">
         var xValues = ["Today’s User", "Total Bookings", "Total Place", "Downloads"];
var yValues = [<?=$total_user_count?>, <?=$total_booking_count?>, <?=$total_place_count?>, <?=$total_download_count?>];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  // "#1e7145"
];

new Chart("myChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      // text: "World Wide Wine Production 2018"
    }
  }
});
var xValues = [<?= $month ?>];
var yValues = [<?= $user_monthly_count?>];
var barColors = [<?= $color?>];

new Chart("acquisitions", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Monthly User Registration"
    }
  }
});
      </script>
      <!-- End custom js for this page-->
   </body>
</html>