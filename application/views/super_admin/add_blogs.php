<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Blogs</title>
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
                                 <h4 class="card-title">Add Blogs</h4>
                                 <?php echo form_open('superadmin/save_blogs_data', array('id'=>'add_blogs_form')) ?>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Title</label>
                                          <input type="text" class="form-control input-text" name="title" placeholder="Title">
                                          <span class="error_msg" id="title_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Upload Image</label>
                                          <input type="file" class="form-control file-text" name="image" placeholder="Upload Image" accept="image/png, image/gif, image/jpeg">
                                          <span class="error_msg" id="image_error"></span>
                                       </div>
                                    </div>                                         
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label>Description</label>
                                          <textarea class="form-control" id="description" name="description"  rows="10"></textarea>
                                            <span class="error_msg" id="description_error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_blogs_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
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
                              <h4 class="card-title">blogs List</h4>
                              <div class="table-responsive">
                                 <table class="table" id="blogs_data_table">
                                    <thead>
                                       <tr>
                                          <th>SR. No</th>
                                          <th>Title</th>
                                          <th>Description</th>
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
               <div id="delete_blogs" class="modal fade">
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
                              <input type="hidden" name="delete_blogs_id" id="delete_blogs_id">
                              <button class="btn btn-primary" id="blogs_del_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal fade" id="edit_blogs_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Edit Blogs Details</h5>
                           <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <?php echo form_open('superadmin/update_blogs_data', array('id'=>'update_blogs_form')) ?>
                        <div class="modal-body">
                             <div class="row">
                                    <input type="hidden" class="form-control input-text" name="edit_id" id="edit_id">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Title</label>
                                          <input type="text" class="form-control input-text" name="edit_title" id="edit_title" placeholder="Title">
                                          <span class="error_msg" id="edit_title_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Upload Image</label>
                                          <input type="file" class="form-control file-text" name="edit_image" id="edit_image" placeholder="Upload Image" accept="image/png, image/gif, image/jpeg">
                                          <span class="error_msg" id="edit_image_error"></span>
                                       </div>
                                       <input type="hidden" name="last_inserted_image" id="last_inserted_image">
                                    </div>     
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <div id="image_data">
                                             
                                          </div>
                                       </div>
                                       
                                    </div>                                         
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label>Description</label>
                                          <textarea class="form-control" id="edit_description" name="edit_description" rows="10"></textarea>
                                            <span class="error_msg" id="edit_description_error"></span>
                                       </div>
                                    </div>
                                 </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success button_color text_color" id="update_blogs_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_blogs.js"></script>
      <!-- End custom js for this page-->
   </body>
</html>