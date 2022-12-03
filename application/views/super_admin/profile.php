<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

 <?php include 'common/cssfiles.php';?>

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <?php include 'common/header.php';?><!-- End Header -->

  <!-- ======= Sidebar ======= -->
    <?php include 'common/sidebar.php';?><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Roles</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url()?>superadmin/add_roles">Home</a></li>
          <!-- <li class="breadcrumb-item">Forms</li> -->
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-md-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Profile</h5>

              <!-- Horizontal Form -->
              <form>
                <div class="row">
                  <div class="col-md-4">
                    <label for="">First Name</label>
                 
                    <input type="text" class="form-control" id="inputText">
                
                  </div>
                   <div class="col-md-4">
                    <label for="">Last Name</label>
                 
                    <input type="text" class="form-control" id="inputText">
                
                  </div>
                  <div class="col-md-4">
                    <label for="">Email</label>
                 
                    <input type="text" class="form-control" id="inputText">
                
                  </div>
                   <div class="col-md-4">
                    <label for="">Mobile No</label>
                 
                    <input type="text" class="form-control" id="inputText">
                
                  </div>
                  <div class="col-md-4">
                    <label for="">User Name</label>
                 
                    <input type="text" class="form-control" id="inputText">
                
                  </div>
                  
                </div>
                <br>
               
                <div class="text-center">
                  <button type="submit" class="btn btn-primary button_color">Submit</button>
                 
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include 'common/footer.php';?><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

   <?php include 'common/jsfiles.php';?>

</body>

</html>