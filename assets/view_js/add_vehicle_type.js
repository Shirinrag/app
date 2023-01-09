$('#add_vehicle_type_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_vehicle_type_form")[0]);
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
            $('#add_vehicle_type_button').button('loading');
        },
        success: function(response) {
            $('#add_vehicle_type_button').button('reset');
            if (response.status == 'success') {
                $('form#add_vehicle_type_form').trigger('reset');
                $('#vehicle_type_data_table').DataTable().ajax.reload(null, false);
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
    table = $('#vehicle_type_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_vehicle_type_data",
        "columns": [{
                "data": null
            },
            {
                "data": "vehicle_type"
            },
            {
                "data": "statusdata",
                "className": "change_vehicle_type",
                render: function(data) {
                    var change_vehicle_type = data.split(",");
                    if (change_vehicle_type[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + change_vehicle_type[1] + '" onclick="change_vehicle_type(' + change_vehicle_type[0] + ',' + change_vehicle_type[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + change_vehicle_type[1] + '" onclick="change_vehicle_type(' + change_vehicle_type[0] + ',' + change_vehicle_type[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_vehicle_type",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_vehicle_type_modal"></i></a></span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#delete_vehicle_type" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_vehicle_type" aria-hidden="true"></i></a>'
                // 
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
// $('#vehicle_type_data_table tbody').on('click', 'td.edit_vehicle_type', function(e) {
    $(document).on("click","#vehicle_type_data_table tbody tr, .edit_vehicle_type tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    
    $('#edit_vehicle_type').val(data1.vehicle_type);
    $('#edit_id').val(data1.id);
    $('#delete_vehicle_id').val(data1.id);
});

function change_vehicle_type(status, id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    $.ajax({
        url: frontend_path + "superadmin/update_vehicle_type_status",
        type: "POST",
        data: {
            'id': user_id,
            'status': user_status
        },
        dataType: 'json',
        // beforeSend:function(){
        //     document.getElementById('header_loader').style.visibility = "visible";
        // },
        success: function(data) {
            // document.getElementById('header_loader').style.visibility = "hidden";
            $('#vehicle_type_data_table').DataTable().ajax.reload(null, false);

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

$('#update_vehicle_type_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_vehicle_type_form")[0]);
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
            $('#update_vehicle_type_button').button('loading');
        },
        success: function(response) {
            $('#update_vehicle_type_button').button('reset');
            if (response.status == 'success') {
                $('form#update_vehicle_type_form').trigger('reset');
                $('#vehicle_type_data_table').DataTable().ajax.reload(null, false);
                $('#edit_vehicle_type_modal').modal('hide');
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

$("#delete-form").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        url: frontend_path + "superadmin/delete_vehicle_type",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend:function(){
            $('#vehicle_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            table.ajax.reload();
            swal({
                    title: "success",
                    text: data.message,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_vehicle_type").modal('hide');
            $('#delete_vehicle_type').button('reset');
        }
    });
}));