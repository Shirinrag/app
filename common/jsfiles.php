 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
 <script src="<?=base_url();?>assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="<?=base_url();?>assets/vendors/chart.js/Chart.min.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?=base_url();?>assets/js/off-canvas.js"></script>
  <script src="<?=base_url();?>assets/js/hoverable-collapse.js"></script>
  <script src="<?=base_url();?>assets/js/template.js"></script>
  <script src="<?=base_url();?>assets/js/settings.js"></script>
  <script src="<?=base_url();?>assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?=base_url();?>assets/js/dashboard.js"></script>
  <script src="<?=base_url();?>assets/js/Chart.roundedBarCharts.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/chosen.jquery.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/init.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/prism.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="<?=base_url()?>assets/js/button-inline-loader.js"></script>
  <script src="<?=base_url()?>assets/view_js/form.js"></script>
  
  <!-- endinject -->
  <script type="text/javascript">
    $(document).ready(function() {
      resizeChosen();
      jQuery(window).on('resize', resizeChosen);
    });
    function resizeChosen() {
        $(".chosen-container").each(function() {
            $(this).attr('style', 'width: 100%');
        });
    }
    var frontend_path ="<?=base_url();?>";
  </script>