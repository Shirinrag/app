<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Bonus Price</title>
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
                                 <h4 class="card-title">Add Bonus Price</h4>
                                 <?php echo form_open('superadmin/save_bonus_price_data', array('id'=>'add_bonus_price_form')) ?>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Bonus Price</label>
                                          <input type="text" class="form-control input-text" name="bonus_amount" placeholder="Bonus Price" onkeypress="return isNumber(event)">
                                          <span class="error_msg" id="bonus_amount_error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_bonus_price_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
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
                              <h4 class="card-title">Bonus Price List</h4>
                              <div class="table-responsive">
                                 <table class="table" id="bonus_price_data_table">
                                    <thead>
                                       <tr>
                                          <th>SR. No</th>
                                          <th>Bonus Price</th>
                                          <th>Status</th>
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
               <!-- <div id="delete_admin" class="modal fade">
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
               </div> -->
               <div class="modal fade" id="edit_bonus_price_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Edit Bonus Price</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <?php echo form_open('superadmin/update_bonus_price_data', array('id'=>'update_bonus_price_form')) ?>
                        <div class="modal-body">
                           <div class="row">
                              <input type="hidden" name="edit_id" id="edit_id">                   
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Bonus Price</label>
                                    <input type="text" class="form-control input-text" name="edit_bonus_price" id="edit_bonus_price" placeholder="Bonus Price">
                                    <span class="error_msg" id="edit_bonus_price_error"></span>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success button_color text_color" id="update_bonus_price_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_bonus_price.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>