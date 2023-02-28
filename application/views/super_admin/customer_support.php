<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Admin</title>
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
                                 <h4 class="card-title">Customer Support</h4>
                                 <?php echo form_open('superadmin/add_complaint', array('id'=>'add_complaint_form')) ?>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>User Type</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="user_type" id="user_type" placeholder="Select User Type">
                                             <option value=""></option>
                                             <option value="1">Register User</option>
                                             <option value="2">Un-Register User</option>
                                          </select>
                                          <span class="error_msg" id="user_type_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4" id="booking_id" style="display: none;">
                                       <div class="form-group">
                                          <label>Booking Id</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_booking_id" id="fk_booking_id" placeholder="Select Booking Id">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($booking_id_list as $booking_id_list_key => $booking_id_list_row) { ?>
                                             <option value="<?=$booking_id_list_row['id']?>"><?=$booking_id_list_row['booking_id']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_booking_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4" id="user_id" style="display: none;">
                                       <div class="form-group">
                                          <label>User Name</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_user_id" id="fk_user_id" placeholder="Select User Name">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($user_list as $user_list_key => $user_list_row) { ?>
                                             <option value="<?=$user_list_row['id']?>"><?=$user_list_row['firstName'].$user_list_row['lastName']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_user_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4" id="un_register_user_id" style="display: none;">
                                       <div class="form-group">
                                          <label>User Name</label>
                                          <input type="text" name="user_name" class="form-control input-text">
                                          <span class="error_msg" id="user_name_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Conatct No</label>
                                          <input type="text" class="form-control input-text" name="contact_no" placeholder="Conatct No">
                                          <span class="error_msg" id="contact_no_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Issue Type</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="fk_issue_type_id" id="fk_issue_type_id" placeholder="Select Admin Role">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($issue_type as $issue_type_key => $issue_type_row) { ?>
                                             <option value="<?=$issue_type_row['id']?>"><?=$issue_type_row['issue_type']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="fk_issue_type_id_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Description</label>
                                          <textarea type="text" class="form-control input-text" name="description" placeholder="Description"></textarea>
                                          <span class="error_msg" id="description_error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_complaint_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php echo form_close() ?>
                        </div>
                     </div>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="card-title">Customer Support List</h4>
                              <nav>
                                 <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Register User Complaint</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Un-Register User Complaint</button>
                                 </div>
                              </nav>
                              <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                                 <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="table-responsive">
                                       <table class="table" id="Complaint_register_table">
                                          <thead>
                                             <tr>
                                                <th>SR. No</th>
                                                <th>Name</th>
                                                <th>Place Name</th>
                                                <th>Booking Id</th>
                                                <th>Issue Type</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Source Type</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="table-responsive">
                                       <table class="table" id="Complaint_un_register_table">
                                          <thead>
                                             <tr>
                                                <th>SR. No</th>
                                                <th>Name</th>
                                                <th>Contact No</th>
                                                <th>Issue Type</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Source Type</th>
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
                  </div>
               </div>
               <!-- Modal -->
               <!-- Modal HTML -->
               <div id="delete_complaint" class="modal fade">
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
               <div class="modal fade" id="edit_register_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Edit Complaint</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <?php echo form_open('superadmin/update_admin_data', array('id'=>'update_admin_form')) ?>
                        <div class="modal-body">
                           <h4>User Details</h4>
                           <br>
                           <div class="row">
                              
                                 <div class="col-md-3">
                              <div class="form-group">
                                    <label>Username</label>
                                    <div><span id="user_name"></span></div>
                                 </div>
                              </div>
                              
                                 <div class="col-md-3">
                              <div class="form-group">
                                    <label>Contact No</label>
                                    <div><span id="contact_no"></span></div>
                                 </div>
                              </div>
                              
                                 <div class="col-md-3">
                              <div class="form-group">
                                    <label>Email</label>
                                    <div><span id="email"></span></div>
                                 </div>
                              </div>
                           </div>
                           <br>
                           <h4>Booking Details</h4>
                           <br>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                 <label>Booking Id</label>
                                 <div><span id="booking_ids"></span></div>
                              </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                 <label>Slot No</label>
                                 <div><span id="slot_no"></span></div>
                              </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                 <label>Place Name</label>
                                 <div><span id="place_name"></span></div>
                              </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                 <label>Car No</label>
                                 <div><span id="car_no"></span></div>
                              </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                 <label>Booking From</label>
                                 <div><span id="booking_from"></span></div>
                              </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                 <label>Booking To</label>
                                 <div><span id="booking_to"></span></div>
                              </div>
                              </div>
                           </div>
                           <br>
                           <h4>Complaint Details</h4>
                           <br>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                 <label>Issue Type</label>
                                 <div><span id="issue_type"></span></div>
                              </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                 <label>Description</label>
                                 <div><span id="description"></span></div>
                              </div>
                              </div>
                              <input type="hidden" name="edit_id" id="edit_id">    
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success button_color text_color" id="update_admin_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/customer_support.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>