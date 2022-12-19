$('#addRows').click(function() {

    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) + 1;

    var html2 = '';
    html2 += '<div class="row"><div class="col-md-4"><div class="form-group"> <label>Add Device</label> <input type="text" class="form-control input-text" name="device[]" id="device_' + new_count + '" placeholder="Add Device"> <span class="error_msg" id="from_hours_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';

    $('#device_data_append').append(html2);

});
$(document).on('click', '#removeRow', function() {
    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) - 1;
    $('#count').val(new_count);
    $(this).closest("div").remove();
});
$('#add_parking_place_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_parking_place_form")[0]);
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
            $('#add_parking_place_button').button('loading');
        },
        success: function(response) {
            $('#add_parking_place_button').button('reset');
            if (response.status == 'success') {
                $('form#add_parking_place_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#price_data_append').html('');
                $('#parking_place_data_table').DataTable().ajax.reload(null, false);
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
