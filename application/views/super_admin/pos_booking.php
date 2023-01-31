<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>POS Booking History</title>
  <!-- plugins:css -->
     <?php include 'common/cssfiles.php';?>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
     <?php include 'common/header.php';?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_settings-panel.html -->
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
   <?php include 'common/sidebar.php';?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">POS Booking History</h4>
                  
                  <div class="table-responsive">
                    <table class="table" id="pos_booking_data_table">
                      <thead>
                        <tr>
                          <th>SR. No</th>
                          <th scope="col">Verifier Name</th>
                          <th scope="col">Device Id</th>
                          <th scope="col">Place Name</th>
                          <th scope="col">Car No</th>
                          <th scope="col">Phone No</th>
                          <th scope="col">From Date</th>
                          <th scope="col">To Date</th>
                          <th scope="col">From Time</th>
                          <th scope="col">To Time</th>
                          <th scope="col">Total Hours</th>
                          <th scope="col">Price</th>
                        </tr>
                      </thead>                      
                    </table>
                  </div>
                </div>
              </div>
            </div>    
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
          <?php include 'common/footer.php';?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
    <?php include 'common/jsfiles.php';?>
    <script type="text/javascript" src="<?=base_url()?>assets/view_js/pos_booking.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
