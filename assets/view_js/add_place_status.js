$('#add_place_status_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_place_status_form")[0]);
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
            $('#add_place_status_button').button('loading');
        },
        success: function(response) {
            $('#add_place_status_button').button('reset');
            if (response.status == 'success') {
                $('form#add_place_status_form').trigger('reset');
                $('#place_status_data_table').DataTable().ajax.reload(null, false);
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
    table = $('#place_status_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_place_status_data",
        "columns": [{
                "data": null
            },
            {
                "data": "place_status"
            },
            {
                "data": "statusdata",
                "className": "change_place_status",
                render: function(data) {
                    var change_place_status = data.split(",");
                    if (change_place_status[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + change_place_status[1] + '" onclick="change_place_status(' + change_place_status[0] + ',' + change_place_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + change_place_status[1] + '" onclick="change_place_status(' + change_place_status[0] + ',' + change_place_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_admin_details",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_place_status_modal"></i></a></span>'
                // <a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_admin" aria-hidden="true"></i></a>
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
// $('#place_status_data_table tbody').on('click', 'td.edit_admin_details', function(e) {
    $(document).on("click","#place_status_data_table tbody tr, .edit_admin_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    
    $('#edit_place_status').val(data1.place_status);
    $('#edit_id').val(data1.id);
});

function change_place_status(status, id) {
    console.log(status);console.log(id);
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    //console.log(domain_id);
    $.ajax({
        url: frontend_path + "superadmin/update_place_status",
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
            $('#place_status_data_table').DataTable().ajax.reload(null, false);

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

$('#update_place_status_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_place_status_form")[0]);
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
            $('#update_place_status_button').button('loading');
        },
        success: function(response) {
            $('#update_place_status_button').button('reset');
            if (response.status == 'success') {
                $('form#update_place_status_form').trigger('reset');
                $('#place_status_data_table').DataTable().ajax.reload(null, false);
                $('#edit_place_status_modal').modal('hide');
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
        url: frontend_path + "superadmin/delete_admin",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend:function(){
            $('#admin_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            table.ajax.reload();
            success_msg(data['message']);
            $("#delete_admin").modal('hide');
            $('#admin_del_button').button('reset');
        }
    });
}));