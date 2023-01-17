$('#save_pos_device_map_form').submit(function (e) {
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
      beforeSend: function () {
         $('#add_admin_button').button('loading');
      },
      success: function (response) {
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
      error: function (error, message) {

      }
   });
   return false;
});
$(document).ready(function () {
   table = $('#pos_device_map_table').DataTable({
      "ajax": frontend_path + "superadmin/display_all_pos_device_map_data",
      "columns": [{
            "data": null
         },
         {
            "data": "pos_device_id",

         },
         {
            "data": "place_name"
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
            "className": "edit_pos_map_device",
            "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_pos_device_map_modal"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#delete_pos_device_map_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_pos_device_map_modal" aria-hidden="true"></i></a></span>'
         },
      ],
      "order": [
         [0, 'desc']
      ]
   });
   table.on('order.dt search.dt', function () {
      table.column(0, {
         search: 'applied',
         order: 'applied'
      }).nodes().each(function (cell, i) {
         cell.innerHTML = i + 1;
      });

   }).draw();
});
$(document).on("click", "#pos_device_map_table tbody tr, .edit_pos_map_device tbody tr td", function () {
   var tr = $(this).closest('tr');
   var row = table.row(tr);
   var data1 = row.data();
   $('#edit_id').val(data1.id);
   $('#delete_pos_device_id').val(data1.id)
   $('#edit_device_id').val(data1.device_id);
   $('#edit_place_id').val(data1.fk_place_id);
   $('#edit_place_id').trigger("chosen:updated");
   $('#edit_device_id').trigger("chosen:updated");
});

$('#update_pos_device_map_details_form').submit(function (e) {
   e.preventDefault();
   var formData = new FormData($("#update_pos_device_map_details_form")[0]);
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
      beforeSend: function () {
         $('#update_pos_device_map_details_form_button').button('loading');
      },
      success: function (response) {
         $('#update_pos_device_map_details_form_button').button('reset');
         if (response.status == 'success') {
            $('form#update_pos_device_map_details_form').trigger('reset');
            $('#edit_pos_device_map_modal').modal('hide');
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
      error: function (error, message) {

      }
   });
   return false;
});

$("#delete-form").on('submit', (function (e) {
   e.preventDefault();
   $.ajax({
      url: frontend_path + "superadmin/delete_pos_device",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      dataType: 'json',
      beforeSend: function () {
         $('#pos_device_del_button').button('loading');
      },
      success: function (data) {
         $('form#delete-form').trigger('reset');
         $('#pos_device_map_table').DataTable().ajax.reload(null, false);
         swal({
            title: "success",
            text: data.message,
            icon: "success",
            dangerMode: true,
            timer: 1500
         });
         $("#delete_pos_device_map_modal").modal('hide');
         $('#pos_device_del_button').button('reset');
      }
   });
}));

function change_status(status, id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var pos_id = id;
    $.ajax({
        url: frontend_path + "superadmin/change_pos_device_map_status",
        type: "POST",
        data: {
            'id': pos_id,
            'status': user_status
        },
        dataType: 'json',
        success: function(data) {
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