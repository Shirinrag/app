$(document).ready(function() {
    $('#user_type').trigger("chosen:updated");
    load_admin_data();
});

function load_admin_data() {
    var dataTable = $('#admin_data_table').DataTable({
        dom: 'lBfrtip',
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        // "ajax": {
        //     url: frontend_path + 'admin/display_all_jps_billing_payment_table',
        //     type: "POST"
        // },
    });
}

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
             $('#add_admin_button').button('reset');
               if (response.status == 'success') {
                   $('form#add_admin_form').trigger('reset');
                   $(".chosen-select-deselect").val('');
                   $('.chosen-select-deselect').trigger("chosen:updated");  
                   $('#admin_data_table').DataTable().ajax.reload(null,false);
                    swal({
                        title: "success",
                        text: response.msg,
                        icon: "success",
                        dangerMode: true,
                        timer: 1500
                     });
               } else if (response.status == 'failure') {
                   error_msg(response.error)
               } else {
                   window.location.replace(response['url']);
               }
           },
           error: function(error, message) {
   
           }
       });
       return false;
   });