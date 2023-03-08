<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Vendor Mapped With Place</title>
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
                                 <h4 class="card-title">Vendor Mapped With Place</h4>
                                 <?php echo form_open('superadmin/save_vendor_map_place', array('id'=>'vendor_mapped_place_form')) ?>
                                
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Vendor</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_vendor_id" id="fk_vendor_id" data-placeholder="Select Vendor">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($vendor_list as $vendor_list_key => $vendor_list_row) { ?>
                                             <option value="<?=$vendor_list_row['id']?>"><?=$vendor_list_row['firstName']." ".$vendor_list_row['lastName']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_vendor_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Place</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_place_id[]" id="fk_place_id" multiple="multiple" data-placeholder="Select Place">
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
                                    
                                 </div>
                                 <hr>
                                 <div id="price_data_append"></div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_vendor_mapped_place_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
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
                              <h4 class="card-title">Vendor Mapped With Place List</h4>
                              <div class="table-responsive">
                                 <table class="table" id="vendor_mapped_place_datatable">
                                    <thead>
                                       <tr>
                                          <th></th>
                                          <th>Vendor Name</th>
                                          <!-- <th>Place Name</th>  -->
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
               <div id="delete_duty_allocation" class="modal fade">
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
                              <input type="hidden" name="delete_duty_allocation_id" id="delete_duty_allocation_id">
                              <button class="btn btn-primary" id="admin_del_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
                <div class="modal fade" id="edit_vendor_map_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Edit Vendor Mapped With Place</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <?php echo form_open('superadmin/update_place_details', array('id'=>'update_place_details_form')) ?>
                        <div class="modal-body">
                           <div class="row">
                              <input type="text" name="edit_id" id="edit_id">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Select Vendor</label>
                                    <select type="text" class="form-control chosen-select-deselect" name="edit_fk_vendor_id" id="edit_fk_vendor_id" placeholder="Select Vendor">
                                       <option value=""></option>
                                       <?php 
                                                foreach ($vendor_list as $vendor_list_key => $vendor_list_row) { ?>
                                             <option value="<?=$vendor_list_row['id']?>"><?=$vendor_list_row['firstName']." ".$vendor_list_row['lastName']?></option>
                                             <?php }
                                                ?>
                                    </select>
                                    <span class="error_msg" id="edit_fk_vendor_id_error"></span>
                                 </div>
                              </div>           
                               <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Place</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="edit_fk_place_id" id="edit_fk_place_id" data-placeholder="Select Place">
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/vendor_mapped_place.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>