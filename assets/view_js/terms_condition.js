$('#update_terms_n_condition_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_terms_n_condition_form")[0]);
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
            $('#add_user_terms_button').button('loading');
        },
        success: function(response) {
            $('#add_user_terms_button').button('reset');
            if (response.status == 'success') {
                swal({
                    title: "success",
                    text: response.message,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
                // location.reload();

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