$(document).ready(function(){
    $("#user_type").change(function(){
        var user_type = $('#user_type').val();
        $("#user_type option:selected").each(function(){
            if($(this).attr("value")==1){
                $("#un_register_user_id").hide();
                $("#booking_id").show();
                $("#user_id").show();
            }
            if($(this).attr("value")== 2){
                $("#booking_id").hide();
                $("#user_id").hide();
                $("#un_register_user_id").show();
            }
            if(user_type == ""){
                 $("#un_register_user_id").hide();
                   $("#booking_id").hide();
                $("#user_id").hide();
            }                
        });
    }).change();
});

$('#add_complaint_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_complaint_form")[0]);
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
            $('#add_complaint_button').button('loading');
        },
        success: function(response) {
            $('#add_complaint_button').button('reset');
            if (response.status == 'success') {
                $('form#add_complaint_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#Complaint_register_table').DataTable().ajax.reload(null, false);
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