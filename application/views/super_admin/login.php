<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
 <?php include 'common/cssfiles.php';?>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo image_data">
                <img src="<?=base_url();?>assets/images/parkingaddalogo.jpg" alt="logo" >

              </div>
              <h4 class="login_data">Login to Your Account</h4>
              <!-- <h6 class="font-weight-light">Sign in to continue.</h6> -->
               <?php echo form_open('common/login', array('id'=>'login_form')) ?>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="login_email" name="login_email" placeholder="Username">
                   <span class="error_msg" id="login_email_error"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="login_password" name="login_password" placeholder="Password">
                  <span class="error_msg" id="login_password_error"></span>
                </div>
                <div class="mt-3 button_data">
                  <button  type="submit" class="btn btn-block btn-lg font-weight-medium auth-form-btn button_color text_color" id="login_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                </div>
               
                 <?php echo form_close() ?>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
 <?php include 'common/jsfiles.php';?>
  <script src="<?=base_url()?>assets/view_js/login.js"></script>

</body>

</html>
