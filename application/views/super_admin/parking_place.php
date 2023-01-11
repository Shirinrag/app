<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Place</title>
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
                                 <h4 class="card-title">Add Place</h4>
                                 <?php echo form_open('superadmin/save_parking_place', array('id'=>'add_parking_place_form')) ?>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Vendor</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_vendor_id" id="fk_vendor_id" placeholder="Select Vendor">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($vendor as $vendor_key => $vendor_row) { ?>
                                             <option value="<?=$vendor_row['id']?>"><?=$vendor_row['firstName']." ".$vendor_row['lastName']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_vendor_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Country</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_country_id" id="fk_country_id" placeholder="Select Country">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($countries_data as $countries_data_key => $countries_data_row) { 
                                                   if($countries_data_row['id']==101){
                                                         $selected = "selected";
                                                      }else{
                                                          $selected = "";
                                                      }
                                                   ?>
                                             <option value="<?=$countries_data_row['id']?>" <?=$selected?>><?=$countries_data_row['name']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_country_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select State</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_state_id" id="fk_state_id" placeholder="Select Country">
                                             <option value=""></option>
                                          </select>
                                          <span class="error_msg" id="fk_state_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select City</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_city_id" id="fk_city_id" placeholder="Select Country">
                                             <option value=""></option>
                                          </select>
                                          <span class="error_msg" id="fk_city_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Place Name</label>
                                          <input type="text" class="form-control input-text" name="place_name" placeholder="Place Name">
                                          <span class="error_msg" id="place_name_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Place Address</label>
                                          <textarea class="form-control input-text" name="address" placeholder="Place Address"></textarea> 
                                          <span class="error_msg" id="address_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Pincode</label>
                                          <input type="text" class="form-control input-text" name="pincode" placeholder="Pincode" onkeypress="return isNumber(event)" maxlength="6">
                                          <span class="error_msg" id="pincode_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Latitude</label>
                                          <input type="text" class="form-control input-text" name="latitude" placeholder="Latitude">
                                          <span class="error_msg" id="latitude_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Longitude</label>
                                          <input type="text" class="form-control input-text" name="longitude" placeholder="Longitude">
                                          <span class="error_msg" id="longitude_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>No. of Slots</label>
                                          <input type="text" class="form-control input-text" name="slots" placeholder="No. of Slots" onkeypress="return isNumber(event)">
                                          <span class="error_msg" id="slots_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Place Status</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_place_status_id" id="fk_place_status_id" placeholder="Select Place Status">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($place_status as $place_status_key => $place_status_row) { ?>
                                             <option value="<?=$place_status_row['id']?>"><?=$place_status_row['place_status']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_place_status_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Price Type</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_parking_price_type" id="fk_parking_price_type" placeholder="Select Price Type">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($price_type as $price_type_key => $price_type_row) { ?>
                                             <option value="<?=$price_type_row['id']?>"><?=$price_type_row['price_type']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_parking_price_type_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Extension Price %</label>
                                          <input type="text" class="form-control input-text" name="ext_price" id="ext_price" placeholder="Extension Price %" onkeypress="return isNumber(event)">
                                          <span class="error_msg" id="ext_price_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Per Hour Extra Charges</label>
                                          <input type="text" class="form-control input-text" name="per_hour_charges" id="per_hour_charges" placeholder="Extension Price %" onkeypress="return isNumber(event)">
                                          <span class="error_msg" id="per_hour_charges_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Vehicle Type</label>
                                          <select type="text" class="form-control chosen-select-deselect" multiple="multiple" name="fk_vehicle_type[]" id="fk_vehicle_type" placeholder="Select Price Type">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($vehicle_data as $vehicle_data_key => $vehicle_data_row) { ?>
                                             <option value="<?=$vehicle_data_row['id']?>"><?=$vehicle_data_row['vehicle_type']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_vehicle_type_error"></span>
                                       </div>
                                    </div>
                                 </div>
                             
                              
                              
                              <div id="price_data_append"></div>
                              <hr>
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
                  <div class="col-md-12">
                     <div class="panel">
                        <div class="card">
                           <div class="card-body">
                              <div class="form-group">
                                 <a href="<?=base_url()?>uploads/excel/add_place.xlsx">Download Sample File</a>
                              </div>
                              <?php echo form_open('superadmin/excel_upload_place', array('id' => 'excel_import_pincode_form')) ?>
                              <div class="col-md-4 ">
                                 <div class="form-group">
                                    <label for="">Upload File</label>
                                    <input type="file" name="excel_upload" class="form-control file-text" id="excel_upload">
                                    <span class="error_msg" id="excel_upload_error"></span>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="float-right">
                                    <div class="form-group " style="margin-top: 2px;" >
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_excel_parking_place_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                                    </div>
                                 </div>
                              </div>
                              <?php echo form_close(); ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-12 grid-margin stretch-card">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="card-title">Place List</h4>
                           <div class="table-responsive">
                              <table class="table" id="parking_place_data_table">
                                 <thead>
                                    <tr>
                                       <th>SR. No</th>
                                       <th>Place Name</th>
                                       <th>Country</th>
                                       <th>Vendor</th>
                                       <!-- <th>Book Type</th> -->
                                       <th>Slots</th>
                                       <th>Status</th>
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
            <div id="delete_admin" class="modal fade">
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
                           <input type="hidden" name="delete_admin_id" id="delete_admin_id">
                           <button class="btn btn-primary" id="admin_del_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                        </form>
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
                     <?php echo form_open('superadmin/update_place_details', array('id'=>'update_place_details_form')) ?>
                     <div class="modal-body">
                        <div class="row">
                           <input type="hidden" name="edit_id" id="edit_id">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Select Vendor</label>
                                 <select type="text" class="form-control chosen-select-deselect" name="edit_fk_vendor_id" id="edit_fk_vendor_id" placeholder="Select Vendor">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($vendor as $vendor_key => $vendor_row) { ?>
                                    <option value="<?=$vendor_row['id']?>"><?=$vendor_row['firstName']." ".$vendor_row['lastName']?></option>
                                    <?php }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="edit_fk_vendor_id_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Select Country</label>
                                 <select type="text" class="form-control chosen-select-deselect" name="edit_fk_country_id" id="edit_fk_country_id" placeholder="Select Country">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($countries_data as $countries_data_key => $countries_data_row) { 
                                         
                                          ?>
                                    <option value="<?=$countries_data_row['id']?>"><?=$countries_data_row['name']?></option>
                                    <?php }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="edit_fk_country_id_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Select State</label>
                                 <select type="text" class="form-control chosen-select-deselect" name="edit_fk_state_id" id="edit_fk_state_id" placeholder="Select Country">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="edit_fk_state_id_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Select City</label>
                                 <select type="text" class="form-control chosen-select-deselect" name="edit_fk_city_id" id="edit_fk_city_id" placeholder="Select Country">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="edit_fk_city_id_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Place Name</label>
                                 <input type="text" class="form-control input-text" name="edit_place_name" id="edit_place_name" placeholder="Place Name">
                                 <span class="error_msg" id="edit_place_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Place Address</label>
                                 <textarea class="form-control input-text" name="edit_address" id="edit_address" placeholder="Place Address"></textarea> 
                                 <span class="error_msg" id="edit_address_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Pincode</label>
                                 <input type="text" class="form-control input-text" name="edit_pincode" id="edit_pincode" placeholder="Pincode" onkeypress="return isNumber(event)" maxlength="6">
                                 <span class="error_msg" id="edit_pincode_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Latitude</label>
                                 <input type="text" class="form-control input-text" name="edit_latitude" id="edit_latitude" placeholder="Latitude">
                                 <span class="error_msg" id="edit_latitude_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Longitude</label>
                                 <input type="text" class="form-control input-text" name="edit_longitude" id="edit_longitude" placeholder="Longitude">
                                 <span class="error_msg" id="edit_longitude_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>No. of Slots</label>
                                 <input type="text" class="form-control input-text" name="edit_slots" id="edit_slots" placeholder="No. of Slots" onkeypress="return isNumber(event)">
                                 <span class="error_msg" id="edit_slots_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Select Place Status</label>
                                 <select type="text" class="form-control chosen-select-deselect" name="edit_fk_place_status_id" id="edit_fk_place_status_id" placeholder="Select Place Status">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($place_status as $place_status_key => $place_status_row) { ?>
                                    <option value="<?=$place_status_row['id']?>"><?=$place_status_row['place_status']?></option>
                                    <?php }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="edit_fk_place_status_id_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Select Price Type</label>
                                 <select type="text" class="form-control chosen-select-deselect" name="edit_fk_parking_price_type" id="edit_fk_parking_price_type" placeholder="Select Price Type">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($price_type as $price_type_key => $price_type_row) { ?>
                                    <option value="<?=$price_type_row['id']?>"><?=$price_type_row['price_type']?></option>
                                    <?php }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="edit_fk_parking_price_type_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Extension Price %</label>
                                 <input type="text" class="form-control input-text" name="edit_ext_price" id="edit_ext_price" placeholder="Extension Price %" onkeypress="return isNumber(event)">
                                 <span class="error_msg" id="edit_ext_price_error"></span>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <h4 class="card-title">Daily Price Slab</h4>
                           <div id="hour_price_details"></div>
                        </div>
                        <hr>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_place.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>