
$('#save_pos_device_map_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_pos_device_map_form")[0]);
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
                $('form#save_pos_device_map_form').trigger('reset');
                $('#pos_device_map_table').DataTable().ajax.reload(null, false);
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
    table = $('#pos_device_map_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_blogs_data",
        "columns": [{
                "data": null
            },
            {
                "data": "title",
                 
            },
            {
                "data": "description"
            },
            {
                "data": null,
                "className": "edit_blogs_details",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_blogs_modal"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#delete_blogs" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_blogs" aria-hidden="true"></i></a></span>'
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
$(document).on("click","#pos_device_map_table tbody tr, .edit_blogs_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    $('#edit_id').val(data1.id);
    $('#delete_blogs_id').val(data1.id)
    $('#edit_title').val(data1.title);
    $('#last_inserted_image').val(data1.image);
    if(data1['image'] !=="")
    {   
        var image = '';
        image = '<img src="' + frontend_path +data1['image'] + '" class="" width="150px" height="150px">';
         $('#image_data').html(image);
    }
    $('#edit_description').val(data1.description);   
});

$('#update_blogs_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_blogs_form")[0]);
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
            $('#update_blogs_button').button('loading');
        },
        success: function(response) {
            $('#update_blogs_button').button('reset');
            if (response.status == 'success') {
                $('form#update_blogs_form').trigger('reset');
                $('#edit_blogs_modal').modal('hide');
                $('#pos_device_map_table').DataTable().ajax.reload(null, false);
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
        url: frontend_path + "superadmin/delete_blogs",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $('#blogs_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            $('#pos_device_map_table').DataTable().ajax.reload(null, false);
           swal({
                    title: "success",
                    text: data.message,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_blogs").modal('hide');
            $('#blogs_del_button').button('reset');
        }
    });
}));