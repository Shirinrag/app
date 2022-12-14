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
                $('#admin_data_table').DataTable().ajax.reload(null, false);
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
    table = $('#admin_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_admin_data",
        "columns": [{
                "data": null
            },
            {
                "data": "firstName"
            },
            {
                "data": "userName"
            },
            {
                "data": "email"
            },
            // { "data": "phoneNo"},
            {
                "data": "user_type_name",
                render: function(data) {
                    var data_info = data;
                    return '<label class="badge badge-success">' + data_info + '</label>';
                },
            },
            {
                "data": "statusdata",
                "className": "change_status",
                render: function(data) {
                    var change_status = data.split(",");
                    if (change_status[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + change_status[1] + '" onclick="change_status(' + change_status[0] + ',' + change_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + change_status[1] + '" onclick="change_status(' + change_status[0] + ',' + change_status[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_admin_details",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_user_modal"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_admin" aria-hidden="true"></i></a></span>'
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
// $('#admin_data_table tbody').on('click', 'td.edit_admin_details', function(e) {
    $(document).on("click","#admin_data_table tbody tr, .edit_admin_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    
    $('#edit_username').val(data1.userName);
    $('#edit_first_name').val(data1.firstName);
    $('#edit_last_name').val(data1.lastName);
    $('#edit_email').val(data1.email);
    $('#edit_contact_no').val(data1.phoneNo);
    $('#edit_user_type').val(data1.user_type);
    $('#edit_user_type').trigger("chosen:updated");
    $('#delete_admin_id').val(data1.id);
    $('#edit_id').val(data1.id);
});

function change_status(status, id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    //console.log(domain_id);
    $.ajax({
        url: frontend_path + "superadmin/change_user_status",
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
            $('#admin_data_table').DataTable().ajax.reload(null, false);

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

$('#update_admin_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_admin_form")[0]);
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
            $('#update_admin_button').button('loading');
        },
        success: function(response) {
            $('#update_admin_button').button('reset');
            if (response.status == 'success') {
                $('form#update_admin_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#admin_data_table').DataTable().ajax.reload(null, false);
                $('#edit_user_modal').modal('hide');
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

// $("#delete-form").on('submit', (function(e) {
//     e.preventDefault();
//     $.ajax({
//         url: frontend_path + "admin/delete_domain",
//         type: "POST",
//         data: new FormData(this),
//         contentType: false,
//         processData: false,
//         dataType: 'json',
//         beforeSend:function(){
//             $('#hlx_addel_button').button('loading');
//         },
//         success: function(data) {
//             $('form#delete-form').trigger('reset');
//             table.ajax.reload();
//             success_msg(data['message']);
//             $("#myModalDelete").modal('hide');
//             $('#hlx_addel_button').button('reset');
//         }
//     });
// }));