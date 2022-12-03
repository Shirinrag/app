
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Vendor JS Files -->
  <script src="<?=base_url();?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?=base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url();?>assets/vendor/chart.js/chart.min.js"></script>
  <script src="<?=base_url();?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?=base_url();?>assets/vendor/quill/quill.min.js"></script>
  <!-- <script src="<?=base_url();?>assets/vendor/simple-datatables/simple-datatables.js"></script> -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

  <script src="<?=base_url();?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?=base_url();?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?=base_url();?>assets/plugins/choosen/chosen.jquery.js"></script>
  <script src="<?=base_url();?>assets/plugins/choosen/init.js"></script>

  <!-- Template Main JS File -->
  <script src="<?=base_url();?>assets/js/main.js"></script>

  <script type="text/javascript">
      setTimeout(function(){
             document.getElementById('loader').style.visibility="hidden";
        },1000);
    $(document).ready(function() {
    resizeChosen();
    jQuery(window).on('resize', resizeChosen);
});


function resizeChosen() {
    $(".chosen-container").each(function() {
        $(this).attr('style', 'width: 100%');
    });
}
var frontend_path = '<?= base_url();?>';
  </script>