<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Verifier Attendance Reports</title>
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
                     <div class="col-lg-12">
                        <div class="col">
                           <div class="card">
                              <div class="card-body">
                                 <h4 class="card-title">Verifier Attendance Reports</h4>
                                 
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>From Date</label>
                                           <input type="text" class="form-control datepicker" name="from_date" id="from_date" placeholder="From Date" onkeypress="return isNumber(event)">
                                          <span class="error_msg" id="from_date_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>To Date</label>
                                           <input type="text" class="form-control datepicker" name="to_date" id="to_date" placeholder="To Date" onkeypress="return isNumber(event)">
                                          <span class="error_msg" id="to_date_error"></span>
                                       </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Place</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_place_id" id="fk_place_id" data-placeholder="Select Place">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($place_details as $place_details_key => $place_details_row) { ?>
                                             <option value="<?=$place_details_row['id']?>"><?=$place_details_row['place_name']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_place_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Verifier</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_verifier_id" id="fk_verifier_id" data-placeholder="Select Verifier">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($verifier_details as $verifier_details_key => $verifier_details_row) { ?>
                                             <option value="<?=$verifier_details_row['id']?>"><?=$verifier_details_row['firstName']." ".$verifier_details_row['lastName']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_verifier_id_error"></span>
                                       </div>
                                    </div> -->
                                 </div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button type="button" class="btn btn-block btn-lg  button_color text_color" id="btn-search-by-date">Submit</button>
                                    </div>
                                 </div>
                                
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="card-title">Verifier Attendance Report List</h4>
                              <div class="table-responsive">
                                <table class="table" id="verifier_attendance_data_report_table">
                                  <thead>
                                    <tr>
                                      <th>SR. No</th>
                                      <th>Verifier Name</th>
                                      <th>Logged In Time</th>
                                      <th>Logged Out Time</th>
                                      <th>Duty Place</th>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/verifier_attendance_report.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>