$('#add_referral_code_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_referral_code_form")[0]);
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
            $('#add_referral_code_button').button('loading');
        },
        success: function(response) {
            $('#add_referral_code_button').button('reset');
            if (response.status == 'success') {
                $('form#add_referral_code_form').trigger('reset');
                $('#referral_code_table').DataTable().ajax.reload(null, false);
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
    table = $('#referral_code_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_referral_code_data",
        "columns": [{
                "data": null
            },
            {
                "data": "referral_code"
            },
            {
                "data": "statusdata",
                "className": "change_referral_code_status",
                render: function(data) {
                    var change_referral_code_status = data.split(",");
                    if (change_referral_code_status[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + change_referral_code_status[1] + '" onclick="change_referral_code_status(' + change_referral_code_status[0] + ',' + change_referral_code_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + change_referral_code_status[1] + '" onclick="change_referral_code_status(' + change_referral_code_status[0] + ',' + change_referral_code_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_referral_code_data",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_referral_code_modal"></i></a></span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_referral_code" aria-hidden="true"></i></a>'
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
    $(document).on("click","#referral_code_table tbody tr, .edit_referral_code_data tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    
    $('#edit_referral_code').val(data1.referral_code);
    $('#edit_id').val(data1.id);
    $('#delete_referral_code_id').val(data1.id);
});

function change_referral_code_status(status, id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    $.ajax({
        url: frontend_path + "superadmin/update_referral_code_status",
        type: "POST",
        data: {
            'id': user_id,
            'status': user_status
        },
        dataType: 'json',
        success: function(data) {
            $('#referral_code_table').DataTable().ajax.reload(null, false);
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

$('#update_referral_code_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_referral_code_form")[0]);
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
            $('#update_referral_code_button').button('loading');
        },
        success: function(response) {
            $('#update_referral_code_button').button('reset');
            if (response.status == 'success') {
                $('form#update_referral_code_form').trigger('reset');
                $('#referral_code_table').DataTable().ajax.reload(null, false);
                $('#edit_referral_code_modal').modal('hide');
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
        url: frontend_path + "superadmin/delete_referral_code",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend:function(){
            $('#referral_code_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            table.ajax.reload();
           swal({
                    title: "success",
                    text: data.msg,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_referral_code").modal('hide');
            $('#referral_code_del_button').button('reset');
        }
    });
}));