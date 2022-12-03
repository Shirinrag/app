<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Booking History</title>
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
      <h1>Booking History</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url()?>superadmin/add_roles">Home</a></li>
          <!-- <li class="breadcrumb-item">Forms</li> -->
          <li class="breadcrumb-item active">Booking History</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-md-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Booking List</h5>

              <!-- Default Table -->
               <table class="table" id="user_data_table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Booking Id</th>
                    <th scope="col">Username</th>
                    <th scope="col">Place Info</th>
                    <th scope="col">From Date</th>
                    <th scope="col">To Date</th>
                    <th scope="col">Checkout Status</th>
                    <th scope="col">Booking Status</th>
                    <th scope="col">Cost</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>1234567890</td>
                   
                    <td>1234567890</td>
                    <td>1234567890</td>
                    <td>1234567890</td>
                    
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>1234567890</td>                    
                    <td>1234567890</td>                    
                    <td>1234567890</td>
                    <td>1234567890</td>
                    
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>                    
                    <td>1234567890</td>
                    <td>1234567890</td>
                    <td>1234567890</td>
                    <td>1234567890</td>
                    
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>1234567890</td>
                    
                    <td>1234567890</td>
                    <td>1234567890</td>
                    <td>1234567890</td>
                    
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>1234567890</td>                   
                    <td>1234567890</td>
                    <td>1234567890</td>
                    <td>1234567890</td>
                    
                  </tr>

                </tbody>
              </table>
              <!-- End Default Table Example -->
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
   <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_users.js"></script>

</body>

</html>