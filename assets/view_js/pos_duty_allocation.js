
$('#addRows').click(function() {

    var latest_count = $('#count_details').val();
    var new_count = parseInt(latest_count) + 1;

    $.ajax({
        type: "POST",
        url: frontend_path + "superadmin/get_pos_verifier_allocation_data",
        dataType: "json",
        cache: false,
       
        success: function(result) {
                var place_list = result.place_list;
                var place_option = "";
                place_option = "<option></option>";
                $.each(place_list, function(place_list_index, place_list_row) {
                    place_option += "<option value=" + place_list_row["id"] + ">" + place_list_row["place_name"] + "</option>";
                });

                var pos_verifier_list = result.pos_verifier_list;
                console.log(result);
                var verifier_option = "";
                verifier_option = "<option></option>";
                $.each(pos_verifier_list, function(pos_verifier_list_index, pos_verifier_list_row) {
                    verifier_option += "<option value=" + pos_verifier_list_row["id"] + ">" + pos_verifier_list_row["firstName"] +pos_verifier_list_row["lastName"] + "</option>";
                });

            var html2 = '';
            html2 += '<div class="row"><div class="col-md-3"> <div class="form-group"> <label>Select Place</label> <select type="text" class="form-control chosen-select-deselect" name="fk_place_id[]" id="fk_place_id_'+new_count+'" data-placeholder="Select Place">'+place_option+' </select> <span class="error_msg" id="fk_place_id_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Select Verifier</label> <select type="text" class="form-control chosen-select-deselect" name="fk_verifier_id[]" id="fk_verifier_id_'+new_count+'" data-placeholder="Select Verifier">'+verifier_option+' </select> <span class="error_msg" id="fk_vendor_id_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Date</label> <input type="text" class="form-control input-text datepicker_'+new_count+'" name="date[]" id="date_'+new_count+'" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="price_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';

            $('#price_data_append').append(html2);
            $("#count_details").val(new_count);
            $(".chosen-select-deselect").chosen({
                width: "100%",
            });
            $(".datepicker_"+new_count).datepicker({ 
               format: 'dd/mm/yyyy',
                autoclose: true, 
                todayHighlight: true
          }).datepicker('update', new Date());

        },
    });

});
$(document).on('click', '#removeRow', function() {
    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) - 1;
    $('#count').val(new_count);
    $(this).closest("div").remove();
});
$('#save_duty_allocation_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_duty_allocation_form")[0]);
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
                $('form#save_duty_allocation_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#price_data_append').html('');
                $('#duty_allocation_table').DataTable().ajax.reload(null, false);
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
    table = $('#duty_allocation_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_duty_allocation_data",
        "columns": [{
                "data": null
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
                "data": "phoneNo"
            },
            {
                "data": "place_name",
                // "render": function ( data, type, row, meta ) {
                   
                //     var html="";
                //      html= data+" ( "+row.address+" ) ";
                //      return html;
                //   },
            },
            {
                "data": "date"
            },
            {
                "data": null,
                "className": "edit_duty_allocation",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#delete_duty_allocation" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_duty_allocation" aria-hidden="true"></i></a></span>'
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
$(document).on("click","#duty_allocation_table tbody tr, .edit_duty_allocation tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
  
    $('#delete_duty_allocation_id').val(data1.id);
});



$("#delete-form").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        url: frontend_path + "superadmin/delete_duty_allocation",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $('#admin_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            table.ajax.reload();
            success_msg(data['message']);
            $("#delete_duty_allocation").modal('hide');
            $('#admin_del_button').button('reset');
        }
    });
}));