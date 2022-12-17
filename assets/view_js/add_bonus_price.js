$('#add_bonus_price_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_bonus_price_form")[0]);
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
            $('#add_bonus_price_button').button('loading');
        },
        success: function(response) {
            $('#add_bonus_price_button').button('reset');
            if (response.status == 'success') {
                $('form#add_bonus_price_form').trigger('reset');
                $('#bonus_price_data_table').DataTable().ajax.reload(null, false);
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
    table = $('#bonus_price_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_bonus_price_data",
        "columns": [{
                "data": null
            },
            {
                "data": "bonus_amount"
            },
            {
                "data": "statusdata",
                "className": "change_bonus_price",
                render: function(data) {
                    var change_bonus_price = data.split(",");
                    if (change_bonus_price[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + change_bonus_price[1] + '" onclick="change_bonus_price(' + change_bonus_price[0] + ',' + change_bonus_price[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + change_bonus_price[1] + '" onclick="change_bonus_price(' + change_bonus_price[0] + ',' + change_bonus_price[1] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    }
                },
            },
            // {
            //     "data": null,
            //     "className": "edit_bonus_price",
            //     "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_bonus_price_modal"></i></a></span>'
            //     // <a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_admin" aria-hidden="true"></i></a>
            // },
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
// $('#bonus_price_data_table tbody').on('click', 'td.edit_bonus_price', function(e) {
    $(document).on("click","#bonus_price_data_table tbody tr, .edit_bonus_price tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    
    $('#edit_bonus_price').val(data1.bonus_amount);
    $('#edit_id').val(data1.id);
});

function change_bonus_price(status, id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    $.ajax({
        url: frontend_path + "superadmin/update_bonus_price_status",
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
            $('#bonus_price_data_table').DataTable().ajax.reload(null, false);

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

$('#update_bonus_price_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_bonus_price_form")[0]);
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
            $('#update_bonus_price_button').button('loading');
        },
        success: function(response) {
            $('#update_bonus_price_button').button('reset');
            if (response.status == 'success') {
                $('form#update_bonus_price_form').trigger('reset');
                $('#bonus_price_data_table').DataTable().ajax.reload(null, false);
                $('#edit_bonus_price_modal').modal('hide');
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