<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Roles</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include 'common/cssfiles.php';?>
</head>

<body>

  <!-- ======= Header ======= -->
  <?php include 'common/header.php';?>
 <!-- End Header -->

  <!-- ======= Sidebar ======= -->
 <?php include 'common/sidebar.php';?><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Roles</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url()?>superadmin/add_roles">Home</a></li>
          <!-- <li class="breadcrumb-item">Forms</li> -->
          <li class="breadcrumb-item active">Roles</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Roles</h5>

              <!-- Horizontal Form -->
              <form>
                <div class="row">
                  <div class="col-md-4">
                    <label for="">Roles</label>
                 
                    <input type="text" class="form-control" id="inputText">
                
                  </div>
                  
                </div>
               
                <div class="text-right">
                  <button type="submit" class="btn btn-primary button_color">Submit</button>
                 
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

           <div class="card">
            <div class="card-body">
              <h5 class="card-title">Role List</h5>

              <!-- Default Table -->
              <table class="table" id="role_data_table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Brandon Jacob</td>
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
                    <td>Bridie Kessler</td>
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
                    <td>Ashleigh Langosh</td>
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
                    <td>Angus Grady</td>
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
                    <td>Raheem Lehner</td>
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
  <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_roles.js"></script>

</body>

</html>