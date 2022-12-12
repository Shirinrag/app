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
                      <tbody>
                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td><label class="badge badge-danger">Pending</label></td>
                          <td>
                        <i class="ti-pencil ti-2x"></i>
                       <i class="ti-trash"></i>
                    </td>
                        </tr>
                        <tr>
                          <td>Messsy</td>
                          <td>53275532</td>
                          <td>15 May 2017</td> <td>53275531</td>
                          <td>12 May 2017</td>
                          <td><label class="badge badge-warning">In progress</label></td>
                           <td>
                        <i class="ti-pencil ti-2x"></i>
                       <i class="ti-trash"></i>
                    </td>
                        </tr>
                        <tr>
                          <td>Messsy</td>
                          <td>53275532</td>
                          <td>15 May 2017</td> <td>53275531</td>
                          <td>12 May 2017</td>
                          <td><label class="badge badge-warning">In progress</label></td>
                           <td>
                        <i class="ti-pencil ti-2x"></i>
                       <i class="ti-trash"></i>
                    </td>
                        </tr>
                         <tr>
                          <td>Messsy</td>
                          <td>53275532</td>
                          <td>15 May 2017</td> <td>53275531</td>
                          <td>12 May 2017</td>
                          <td><label class="badge badge-warning">In progress</label></td>
                           <td>
                        <i class="ti-pencil ti-2x"></i>
                       <i class="ti-trash"></i>
                    </td>
                        </tr> <tr>
                          <td>Messsy</td>
                          <td>53275532</td>
                          <td>15 May 2017</td> <td>53275531</td>
                          <td>12 May 2017</td>
                          <td><label class="badge badge-warning">In progress</label></td>
                           <td>
                        <i class="ti-pencil ti-2x"></i>
                       <i class="ti-trash"></i>
                    </td>
                        </tr> <tr>
                          <td>Messsy</td>
                          <td>53275532</td>
                          <td>15 May 2017</td> <td>53275531</td>
                          <td>12 May 2017</td>
                          <td><label class="badge badge-warning">In progress</label></td>
                           <td>
                        <i class="ti-pencil ti-2x"></i>
                       <i class="ti-trash"></i>
                    </td>
                        </tr>
                      </tbody>
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
    <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_admin.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
