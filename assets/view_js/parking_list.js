$(document).ready(function() {
    load_parking_place_data();
});

function load_parking_place_data() {
    var dataTable = $('#parking_place_data_table').DataTable({
        // dom: 'lBfrtip',
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "ajax": {
            url: frontend_path + 'superadmin/display_all_parking_place_data',
            type: "POST"
        },
    });
}
$(document).on("click", ".edit_place_data", function() {
    var id = $(this).attr("id");
    $.ajax({
        url: frontend_path + "superadmin/get_parking_place_details_on_id",
        method: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function(data) {
            var info = data['parking_place_data'];
            var slot_info = data['slot_info'];
            var device_data = data['device_data'];
            console.log(slot_info);
           
            $("#edit_id").val(info['id']);
            $('#edit_fk_vendor_id').text(info['firstName']+" "+info['lastName']);
            $('#edit_fk_country_id').text(info['country_name']);
            $('#edit_fk_state_id').text(info['state_name']);
            $('#edit_fk_city_id').text(info['city_name']);
            $('#edit_place_name').text(info['place_name']);
            $('#edit_address').text(info['address']);
            $('#edit_pincode').text(info['pincode']);
            $('#edit_latitude').text(info['latitude']);
            $('#edit_longitude').text(info['longitude']);
            $('#edit_slots').text(info['slots']);
            $('#edit_fk_place_status_id').text(info['place_status']);
            $('#edit_fk_parking_price_type').text(info['price_type']);
            $('#edit_ext_price').text(info['ext_price']);
            
            var html = "";
            var machine_id = "";
            $.each(slot_info, function(slot_info_index, slot_info_row) {
                
                if (slot_info_row['fk_machine_id'] == null) {
                    machine_id = "";
                } else {
                    machine_id = slot_info_row['fk_machine_id'];
                }

                var selected = "";
                var option_html="";
                var change_status="";
                var change_status1="";
                $.each(device_data, function(device_data_index, device_data_row) {
                     option_html +='<option value=""></option>';
                            if(device_data_row['id']==machine_id){

                                    selected = "selected";
                            }else{
                                selected = "";
                            }
                        option_html +='<option '+selected+' value="'+device_data_row['id']+'">'+device_data_row['device_id']+'</option>';
                });
                if(slot_info_row['fk_machine_status']==1){
                    change_status +='<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + slot_info_row['fk_machine_status'] + '" onclick="machine_status(' + slot_info_row['slot_info_id'] + ',' + slot_info_row['fk_machine_status'] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                }else{
                    change_status +='<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + slot_info_row['fk_machine_status'] + '" onclick="machine_status(' + slot_info_row['slot_info_id'] + ',' + slot_info_row['fk_machine_status'] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                }

                if(slot_info_row['del_status']==1){
                    change_status1 +='<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch' + slot_info_row['del_status'] + '" onclick="del_status(' + slot_info_row['slot_info_id'] + ',' + slot_info_row['del_status'] + ',' + slot_info_row['fk_place_id'] + ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                }else{
                    change_status1 +='<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch' + slot_info_row['del_status'] + '" onclick="del_status(' + slot_info_row['slot_info_id'] + ',' + slot_info_row['del_status'] + ',' + slot_info_row['fk_place_id'] +  ');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                }
                html += "<div class='row'><input type='hidden' name='edit_slot_id[]' id='edit_slot_id_" + slot_info_index +"' value='"+slot_info_row['slot_info_id']+"' ><div class='col-md-2'><div class='form-group'><label>Slot Name</label><br><span class='data_fetch'>" + slot_info_row['slot_name'] + "</span></div></div><div class='col-md-2'><div class='form-group'><label>Display Id</label><br><span class='data_fetch'>" + slot_info_row['display_id'] + "</span></div></div><div class='col-md-2'><div class='form-group'><label>Machine Id</label><br><select name='fk_machine_id[]' id='fk_machine_id_"+slot_info_row['slot_info_id']+"' class='form-control chosen-select-deselect select_data'>'"+option_html+"'</select></div></div><div class='col-md-2'><div class='form-group'><label> Device Status</label><div>"+change_status+"</div></div></div><div class='col-md-2'><div class='form-group'><label> Delete Device</label><div>"+change_status1+"</div></div></div></div>";
                // <input type='text' name='fk_machine_id[]' id='fk_machine_id_"+slot_info_row['slot_info_id']+"' class='form-control input-text' placeholder='Machine Id'>
            });
            $('#machine_details').html(html);
            $(".chosen-select-deselect").chosen({
                    width: "100%",
                });
        },
    });
});
$('#save_device_mapped_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_device_mapped_form")[0]);
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
                $('form#save_device_mapped_form').trigger('reset');
                $('#edit_place_modal').modal('hide');
                // $(".chosen-select-deselect").val('');
                // $('.chosen-select-deselect').trigger("chosen:updated");
                // $('#price_data_append').html('');
                $('#parking_place_data_table').DataTable().ajax.reload(null, false);
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

function machine_status(id, status) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    //console.log(domain_id);
    $.ajax({
        url: frontend_path + "superadmin/update_machine_device_status",
        type: "POST",
        data: {
            'id': user_id,
            'status': user_status
        },
        dataType: 'json',
       
        success: function(data) {
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

function del_status(id, status, place_id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    var place_id = place_id;
    //console.log(domain_id);
    $.ajax({
        url: frontend_path + "superadmin/update_delete_device_status",
        type: "POST",
        data: {
            'id': user_id,
            'status': user_status,
            'place_id': place_id
        },
        dataType: 'json',
       
        success: function(data) {
            swal({
                title: "success",
                text: data.message,
                icon: "success",
                dangerMode: true,
                timer: 1500
            });

            $("#edit_place_modal .modal-body").load(target, function() { 
                 $("#edit_place_modal").modal("show"); 
            });
        }
    });
}