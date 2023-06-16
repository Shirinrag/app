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
                                 <?php echo form_open('welcome/save_new_data', array('id'=>'add_admin_form')) ?>
                                 <div class="row">
                                     <div class="col-md-4">
                                       <div class="form-group">
                                          <label>Enter Place name<span class="text-danger">*</span></label>
                                          <input type="text"  name="message" dir="ltl" id="message"  class="form-control" placeholder="Enter product name">
                                       </div>
                                    </div>
                                    
                                 </div>
                                 <div class="row">
                                    <div class="float-right">
                                       <button  type="submit" class="btn btn-block btn-lg  button_color text_color" id="add_admin_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                                    </div>
                                 </div>
                                 <?php echo form_close() ?>
                                 <div class="row ml20 mb20"  id="product_desc">
                              <div class="col-sm-12">
                                 <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" dir="ltl" name="description" id="description" ><?php
                                        foreach($data as $data_key => $data_row){
                                            // $message = $data_row['message'];
                                            echo $data_row['message'].'</br>';
                                        } ?>
                                    
                                    </textarea>
                                 </div>
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
      <!-- <script type="text/javascript" src="<?=base_url()?>assets/view_js/add_admin.js"></script> -->
      <script type="text/javascript">
         $('#add_admin_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData($("#add_admin_form")[0]);
            var InvoiceTypeForm = $(this);
            jQuery.ajax({
                dataType: 'json',
                type: 'POST',
                url: InvoiceTypeForm.attr('action'),
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                beforeSend: function() {
                    $('#add_admin_button').button('loading');
                },
                success: function(response) {
                    console.log(response);
                    const myTimeout = setTimeout(myGreeting, 5000);
                    function myGreeting() {
                        document.getElementById("description").innerHTML;
                    }
                    $('#add_admin_button').button('reset');
                    if (response.status == 'success') {
                        $('form#add_admin_form').trigger('reset');
                        $(".chosen-select-deselect").val('');
                        $('.chosen-select-deselect').trigger("chosen:updated");
                        $('#admin_data_table').DataTable().ajax.reload(null, false);
                        swal({
                            title: "success",
                            text: response.msg,
                            icon: "success",
                            dangerMode: true,
                            timer: 1500
                        });
                        $("#product_desc").load(window.location.href + " #product_desc" );
                    
                            
                    } else if (response.status == 'failure') {
                       swal({
                            title: "warning",
                            text: response.message,
                            icon: "warning",
                            dangerMode: true,
                            timer: 1500
                        });
                    } else {
                        window.location.replace(response['url']);
                    }
                },
                error: function(error, message) {
        
                }
            });
            return false;
        });
        
        $(document).ready(function(){
            setInterval(function(){
                  $("#product_desc").load(window.location.href + " #product_desc" );
                //   console.log("123");
                //   console.log(CKEDITOR);
                //   CKEDITOR.instances.description.destroy();
                // CKEDITOR.instances.description.destroy();
                // // CKEDITOR.destroy('description');
                // //   CKEDITOR.replace('description');
                //   console.log("456");
            }, 10000);

        });
      </script>
      <!-- End custom js for this page-->
   </body>
</html>