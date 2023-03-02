<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Booking History</title>
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
                  <h4 class="card-title">Booking History</h4>
                  <nav>
                                 <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Booking</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Extend Booking</button>
                                 </div>
                              </nav>
                              <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                                 <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="table-responsive">
                                       <table class="table" id="booking_table">
                                          <thead>
                                             <tr>
                                                <th>SR. No</th>
                                                <th>Booking Id</th>
                                                <th>User Name</th>
                                                <th>Place Name</th>          
                                                <th>Booking From Date & Time</th>
                                                <th>Booking To Date & Time</th>
                                                <th>Booking Status</th>
                                                <th>Cost</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="table-responsive">
                                       <table class="table" id="extend_booking_table">
                                          <thead>
                                             <tr>
                                                <th>SR. No</th>
                                                <th>Booking Id</th>        
                                                <th>Booking From Date & Time</th>
                                                <th>Booking To Date & Time</th>
                                                <th>Cost</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                  <!-- <div class="table-responsive">
                    <table class="table" id="user_data_table">
                      <thead>
                        <tr>
                          <th>SR. No</th>
                          <th scope="col">Booking Id</th>
                          <th scope="col">Username</th>
                          <th scope="col">Place Info</th>
                          <th scope="col">From Date</th>
                          <th scope="col">To Date</th>
                          <th scope="col">Checkout Status</th>
                          <th scope="col">Booking Status</th>
                          <th scope="col">Cost</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                      
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>
                                               <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                      
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                      
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                      
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                      
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                      
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                      
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>
                      </tbody>
                    </table>
                  </div> -->
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
    <script type="text/javascript" src="<?=base_url()?>assets/view_js/booking_history.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
