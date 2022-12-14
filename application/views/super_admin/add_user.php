<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User List</title>
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
                  <h4 class="card-title">User List</h4>
                  
                  <div class="table-responsive">
                    <table class="table" id="user_data_table">
                      <thead>
                        <tr>
                          <th>SR. No</th>
                          <th>Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Contact No</th>
                          <th>Car No.</th>
                          <th>OTP Verified</th>
                          <th>Status</th>
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
    <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_users.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
