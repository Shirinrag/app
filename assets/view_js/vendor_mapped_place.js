$('#vendor_mapped_place_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#vendor_mapped_place_form")[0]);
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
            $('#add_vendor_mapped_place_button').button('loading');
        },
        success: function(response) {
            $('#add_vendor_mapped_place_button').button('reset');
            if (response.status == 'success') {
                $('form#vendor_mapped_place_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#vendor_mapped_place_datatable').DataTable().ajax.reload(null, false);
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
    function format(d) {
        var html = '';       
        var place_name = d.place_name;
        if (place_name) {
            if (place_name.indexOf(';') > -1) {
                var place_name_1 = place_name.split(";");
            } else {
                var place_name_1 = [place_name];
            }
        } else {
            var place_name_1 = [0];
        }

        // var id = d.id;
        // if (id) {
        //     if (id.indexOf(',') > -1) {
        //         var id_1 = id.split(",");
        //     } else {
        //         var id_1 = [id];
        //     }
        // } else {
        //     var id_1 = ['NA'];
        // }


        html +=
            '<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-hover">' +
            '<tr>' + '<th>Place Name</th>' +'</tr>';
        $.each(place_name_1, function(place_name_1key, place_name_1_val) {
            html += '<tr>' +
                '<td>' + place_name_1_val + '</td>' +
                '</tr>';
        });
        html += '</table>';
        return html;

    }

    $(document).ready(function() {
        var table = $('#vendor_mapped_place_datatable').DataTable({
            "ajax": frontend_path+"superadmin/display_all_vendor_map_place_data",
            "columns": [{
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {
                    "data": "firstName",
                  "render": function ( data, type, row, meta ) {
                  
                    var html="";
                     html= data+" "+row.lastName;
                     return html;
                  },
                },
                 {
                "data": null,
                // "className": "edit_admin_details",
                // "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_vendor_map_model"></i></a></span>'
                 "render": function ( data, type, row, meta ) {
                  
                    var html ='<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1 edit_vendor_map_place" title="Edit Details" id="'+row.tbl_vendor_id+'" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_vendor_map_model"></i></a></span>';  
                    return html;
                  },
            },

            ],
            "order": [
                [1, 'DESC']
            ]
        });

        // Add event listener for opening and closing details
        $('#vendor_mapped_place_datatable tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        // $(document).on("click","#vendor_mapped_place_datatable tbody tr, .edit_admin_details tbody tr td",function(){
        //     var tr = $(this).closest('tr');
        //     var row = table.row(tr);
        //     var data1 = row.data();
            
        //     $('#edit_fk_place_id').val(data1.fk_place_id);
        //     $('#edit_fk_place_id').trigger("chosen:updated");
        //     $('#edit_fk_vendor_id').val(data1.fk_vendor_id);
        //     $('#edit_fk_vendor_id').trigger("chosen:updated");
        //     $('#delete_admin_id').val(data1.tbl_vendor_id);
        //     $('#edit_id').val(data1.tbl_vendor_id);
        // });
    });
$(document).on('click', '.edit_vendor_map_place', function () {
    var id = $(this).attr("id");   
    $.ajax({
        url: frontend_path + 'superadmin/get_vendor_map_place_data_on_id',
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",        
        success: function (data) {
                var info = data.vendor_map_data;         
                var place_list = data.place_list;
                var selected_parking_place_id = data.selected_parking_place_id;
                var place_list_option_data ="";
                $('#edit_fk_vendor_id').val(info.vendor_id);
                $('#edit_fk_vendor_id').trigger("chosen:updated");
                $('#tbl_vendor_map_place_id').val(info.tbl_vendor_map_place_id);
                // $('#delete_admin_id').val(info.tbl_vendor_id);
                $('#edit_id').val(info.tbl_vendor_id);
                $.each(place_list, function(place_list_index, place_list_row) {
                    if(jQuery.inArray(place_list_row['id'],selected_parking_place_id['fk_place_id']) !== -1){
                        place_list_option_data +='<option value="' + place_list_row['id'] + '" selected >' + place_list_row['place_name'] + '</option>';
                    }else{
                        place_list_option_data +='<option value="' + place_list_row['id'] + '">' + place_list_row['place_name'] + '</option>';
                    }
                });
                $('#edit_fk_place_id').html(place_list_option_data);
                $('#edit_fk_place_id').trigger("chosen:updated");
            },
    });
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
        success: function(data) {
            $('#vendor_mapped_place_datatable').DataTable().ajax.reload(null, false);
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

$('#update_vendor_map_place_data_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_vendor_map_place_data_form")[0]);
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
                $('form#update_vendor_map_place_data_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#vendor_mapped_place_datatable').DataTable().ajax.reload(null, false);
                $('#edit_vendor_map_model').modal('hide');
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