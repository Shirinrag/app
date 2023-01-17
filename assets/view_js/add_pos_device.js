$('#addRows').click(function() {

    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) + 1;

    var html2 = '';
    html2 += '<div class="row"><div class="col-md-4"><div class="form-group"> <label>Add Device</label> <input type="text" class="form-control input-text" name="device_id[]" id="device_id_' + new_count + '" placeholder="Add Device"> <span class="error_msg" id="from_hours_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';

    $('#device_data_append').append(html2);
      $("#count").val(new_count);

});
$(document).on('click', '#removeRow', function() {
    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) - 1;
    $('#count').val(new_count);
    $(this).closest("div").remove();
});
$('#add_pos_device_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_pos_device_form")[0]);
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
                $('form#add_pos_device_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#device_data_append').html('');
                $('#pos_device_data_table').DataTable().ajax.reload(null, false);
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
$(document).ready(function() {
    table = $('#pos_device_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_pos_device_data",
        "columns": [{
                "data": null
            },
            {
                "data": "pos_device_id"
            },
            {
                "data": "statusdata",
                "className": "device_status",
                render: function(data) {
                    var device_status = data.split(",");
                    if (device_status[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + device_status[1] + '" onclick="device_status(' + device_status[0] + ',' + device_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + device_status[1] + '" onclick="device_status(' + device_status[0] + ',' + device_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    }
                },
            },
        ],
        "order": [
            [0, 'desc']
        ]
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });

    }).draw();
});
function device_status(status, id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    $.ajax({
        url: frontend_path + "superadmin/change_pos_device_status",
        type: "POST",
        data: {
            'id': user_id,
            'status': user_status
        },
        dataType: 'json',
        success: function(data) {
            // document.getElementById('header_loader').style.visibility = "hidden";
            $('#pos_device_data_table').DataTable().ajax.reload(null, false);

            swal({
                title: "success",
                text: data.message,
                icon: "success",
                dangerMode: true,
                timer: 1500
            });
        }
    });
}