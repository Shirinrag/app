<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>POS Verifier Duty Allocation</title>
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
                                 <h4 class="card-title">Add POS Verifier Duty Allocation</h4>
                                 <?php echo form_open('superadmin/save_pos_vrifier_duty_allocation', array('id'=>'save_pos_vrifier_duty_allocation_form')) ?>
                                 <div class="row">
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label>Select Place</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_place_id[]" id="fk_place_id_0" data-placeholder="Select Place">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($place_list as $place_list_key => $place_list_row) { ?>
                                             <option value="<?=$place_list_row['id']?>"><?=$place_list_row['place_name']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_place_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label>Select POS Verifier</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_pos_verifier_id[]" id="fk_pos_verifier_id_0" data-placeholder="Select POS Verifier">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($pos_verifier_list as $pos_verifier_list_key => $pos_verifier_list_row) { ?>
                                             <option value="<?=$pos_verifier_list_row['id']?>"><?=$pos_verifier_list_row['firstName']." ".$pos_verifier_list_row['lastName']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_pos_verifier_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <label>Date</label>
                                          <input type="text" class="form-control datepicker" name="date[]" id="date_0" placeholder="Price" onkeypress="return isNumber(event)">
                                          <span class="error_msg" id="date_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-2">
                                       <button id="addRows" type="button" class="btn btn-info" style="margin-top: 22px; margin-left: -20px;"><i class="icon-plus"></i>
                                       </button>
                                       <input type="hidden" class="form-control"  name="count" id="count_details" value="0">
                                    </div>
                                 </div>
                                 <hr>
                                 <div id="pos_duty_data_append"></div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_parking_place_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                                    </div>
                                 </div>
                                 <?php echo form_close() ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="card-title">POS Verifier Duty Allocation List</h4>
                              <div class="table-responsive">
                                 <table class="table" id="pos_duty_allocation_table">
                                    <thead>
                                       <tr>
                                          <th>SR. No</th>
                                          <th>Verifier Name</th>
                                          <th>Contact No</th>
                                          <th>Place Name</th>
                                          <th>Duty Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Modal -->
               <!-- Modal HTML -->
               <div id="delete_pos_duty_allocation" class="modal fade">
                  <div class="modal-dialog modal-confirm">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Are you sure</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <p>Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                           <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                           <form method="POST" id="delete-form">
                              <input type="hidden" name="delete_pos_duty_allocation_id" id="delete_pos_duty_allocation_id">
                              <button class="btn btn-primary" id="delete_pos_duty_allocation_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                           </form>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/pos_duty_allocation.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>