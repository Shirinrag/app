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
                  <h4 class="card-title">Parking List</h4>
                  
                  <div class="table-responsive">
                    <table class="table" id="parking_place_data_table">
                      <thead>
                        <tr>
                         <th>SR. No</th>
                          <th>Place Name</th>
                          <th>Address</th>
                          <th>Vendor</th>
                          <th>Slots</th>
                          <!-- <th>Status</th> -->
                          <th>Action</th>                          
                        </tr>
                      </thead>
                     
                    </table>
                  </div>
                </div>
              </div>
            </div>          
          </div>
           <div class="modal fade" id="edit_place_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Edit Place Details</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <?php echo form_open('superadmin/save_device_mapped', array('id'=>'save_device_mapped_form')) ?>
                        <div class="modal-body">
                           <div class="row">
                              <input type="hidden" name="edit_id" id="edit_id">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Vendor Name</label>                                    
                                    <div><span id="edit_fk_vendor_id"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Select Country</label>
                                    <div><span id="edit_fk_country_id"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Select State</label>
                                     <div><span id="edit_fk_state_id"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Select City</label>
                                    <div><span id="edit_fk_city_id"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Place Name</label>
                                     <div><span id="edit_place_name"></span></div>
                                    
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Place Address</label>
                                     <div><span id="edit_address"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Pincode</label>
                                    <div><span id="edit_pincode"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Latitude</label>
                                    <div><span id="edit_latitude"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Longitude</label>
                                     <div><span id="edit_longitude"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>No. of Slots</label>
                                    <div><span id="edit_slots"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Select Place Status</label>
                                    <div><span id="edit_fk_place_status_id"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Select Price Type</label>
                                    <div><span id="edit_fk_parking_price_type"></span></div>
                                    
                                 </div>
                              </div>
                              <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Extension Price %</label>
                                          <div><span id="edit_ext_price"></span></div>
                                          
                                       </div>
                                    </div>
                           </div>
                          <!--  <div class="row">
                                    <h4 class="card-title">Daily Price Slab</h4>
                                    <div id="hour_price_details"></div>

                           </div>
                           <hr> -->
                           <div class="row">
                                    <h4 class="card-title">Machine Details</h4>
                                    <div id="machine_details"></div>             
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success button_color text_color" id="update_place_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                           <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        <?php echo form_close() ?>
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
    <script type="text/javascript" src="<?=base_url()?>assets/view_js/parking_list.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
