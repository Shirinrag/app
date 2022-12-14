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
                                 <h4 class="card-title">Add Admin</h4>
                                 <?php echo form_open('superadmin/save_admin_data', array('id'=>'add_admin_form')) ?>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Username</label>
                                          <input type="text" class="form-control input-text" name="username" placeholder="Username">
                                          <span class="error_msg" id="username_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>First Name</label>
                                          <input type="text" class="form-control input-text" name="first_name" placeholder="First Name">
                                          <span class="error_msg" id="first_name_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Last Name</label>
                                          <input type="text" class="form-control input-text" name="last_name" placeholder="Last Name">
                                          <span class="error_msg" id="last_name_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Email</label>
                                          <input type="text" class="form-control input-text" name="email" placeholder="Email">
                                          <span class="error_msg" id="email_error"></span>
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
                                          <label>Password</label>
                                          <input type="text" class="form-control input-text" name="password" placeholder="Password">
                                          <span class="error_msg" id="password_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Select Admin Role</label>
                                          <select type="text" class="form-control chosen-select-deselect" name="user_type" id="user_type" placeholder="Select Admin Role">
                                             <option value=""></option>
                                             <?php 
                                                foreach ($user_type_data as $user_type_data_key => $user_type_data_row) { ?>
                                             <option value="<?=$user_type_data_row['id']?>"><?=$user_type_data_row['user_type']?></option>
                                             <?php }
                                                ?>
                                          </select>
                                          <span class="error_msg" id="user_type_error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_admin_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
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
                              <h4 class="card-title">Admin List</h4>
                              <div class="table-responsive">
                                 <table class="table" id="admin_data_table">
                                    <thead>
                                       <tr>
                                          <th>SR. No</th>
                                          <th>Name</th>
                                          <th>Username</th>
                                          <th>Email</th>
                                          <th>Role</th>
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
                              <input type="hidden" name="delete_domain_id" id="delete_domain_id">
                              <button class="btn btn-primary" id="hlx_addel_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Edit Admin Details</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <?php echo form_open('superadmin/update_admin_data', array('id'=>'update_admin_form')) ?>
                        <div class="modal-body">
                           <div class="row">
                              <input type="hidden" name="ediit_id" id="edit_id">                   
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control input-text" name="edit_username" id="edit_username" placeholder="Username" readonly>
                                    <span class="error_msg" id="edit_username_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control input-text" name="edit_first_name" id="edit_first_name"placeholder="First Name">
                                    <span class="error_msg" id="edit_first_name_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control input-text" name="edit_last_name" id="edit_last_name" placeholder="Last Name">
                                    <span class="error_msg" id="edit_last_name_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control input-text" name="edit_email" id="edit_email" placeholder="Email">
                                    <span class="error_msg" id="edit_email_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Conatct No</label>
                                    <input type="text" class="form-control input-text" name="edit_contact_no" id="edit_contact_no"placeholder="Conatct No">
                                    <span class="error_msg" id="edit_contact_no_error"></span>
                                 </div>
                              </div>
                              <!-- <div class="col-md-4">
                                 <div class="form-group">
                                   <label>Password</label>
                                   <input type="text" class="form-control input-text" name="edit_password" placeholder="Password">
                                   <span class="error_msg" id="password_error"></span>
                                 </div>                         
                                 </div> -->
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Select Admin Role</label>
                                    <select type="text" class="form-control chosen-select-deselect" name="edit_user_type" id="edit_user_type" placeholder="Select Admin Role">
                                       <option value=""></option>
                                       <?php 
                                          foreach ($user_type_data as $user_type_data_key => $user_type_data_row) { ?>
                                       <option value="<?=$user_type_data_row['id']?>"><?=$user_type_data_row['user_type']?></option>
                                       <?php }
                                          ?>
                                    </select>
                                    <span class="error_msg" id="edit_user_type_error"></span>
                                 </div>
                              </div>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_admin.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>