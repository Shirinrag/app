<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin </title>
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
      <h1>Admin</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url()?>superadmin/add_roles">Home</a></li>
          <!-- <li class="breadcrumb-item">Forms</li> -->
          <li class="breadcrumb-item active">Admin </li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-md-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admin </h5>

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
                    <label for="">User  Name</label>
                 
                    <input type="text" class="form-control" id="inputText">
                
                  </div>
                  <div class="col-md-4">
                    <label for="">Select Role</label>
                    <select class="form-control chosen-select-deselect" data-place-holder="Select Role">
                      <option value="">1</option>
                      <option value="">1</option>
                      <option value="">1</option>
                      <option value="">1</option>
                      <option value="">1</option>
                    </select>
                
                  </div>
                  
                </div>
                <br>
               
                <div class="text-right">
                  <button type="submit" class="btn btn-primary button_color">Submit</button>
                 
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admin  List</h5>

              <!-- Default Table -->
               <table class="table" id="Admin _data_table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Admin name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact No</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>  <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                      <label class="form-check-label " for="flexSwitchCheckChecked"></label>
                    </div></td>
                    <td>
                       <i class="bi bi-pencil-fill"></i>
                       <i class="bi bi-trash-fill"></i>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>  <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                      <label class="form-check-label " for="flexSwitchCheckChecked"></label>
                    </div></td>
                     <td>
                       <i class="bi bi-pencil-fill"></i>
                       <i class="bi bi-trash-fill"></i>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>  <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                      <label class="form-check-label " for="flexSwitchCheckChecked"></label>
                    </div></td>
                     <td>
                       <i class="bi bi-pencil-fill"></i>
                       <i class="bi bi-trash-fill"></i>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>  <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                      <label class="form-check-label " for="flexSwitchCheckChecked"></label>
                    </div></td>
                     <td>
                       <i class="bi bi-pencil-fill"></i>
                       <i class="bi bi-trash-fill"></i>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>Brandon Jacob</td>
                    <td>1234567890</td>
                    <td>  <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                      <label class="form-check-label " for="flexSwitchCheckChecked"></label>
                    </div></td>
                     <td>
                       <i class="bi bi-pencil-fill"></i>
                       <i class="bi bi-trash-fill"></i>
                    </td>
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
   <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_admin.js"></script>

</body>

</html>