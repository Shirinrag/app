$(document).ready(function() {
    var id = $("#fk_country_id").val();

    $.ajax({
        type: "POST",
        url: frontend_path + "superadmin/get_state_data_on_country_id",
        data: {
            country_id: id
        },
        dataType: "json",
        cache: false,
        // beforeSend: function() {
        //     document.getElementById('loader').style.visibility = "visible";
        //     // $("#loader").fadeIn("slow");
        // },
        success: function(result) {
            // document.getElementById('loader').style.visibility = "hidden";
            if (result["status"] == "success") {
                var state_data = result.state_data;
                var html = "";
                html += '<option value=""></option>';
                $.each(state_data, function(state_data_index, state_data_row) {
                    html += '<option value="' + state_data_row.id + '">' + state_data_row.name + "</option>";
                });
                $("#fk_state_id").html(html);
                $("#fk_state_id").trigger("chosen:updated");
            } else if (result["status"] == "failure") {
                $("#fk_state_id").html("");
                $("#fk_state_id").trigger("chosen:updated");
            } else if (result["status"] == "login_failure") {
                window.location.replace(result["url"]);
            } else {

            }
        },
    });
});
$(document).on("change", "#fk_country_id", function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "superadmin/get_state_data_on_country_id",
        data: {
            country_id: id
        },
        dataType: "json",
        cache: false,
        // beforeSend: function() {
        //     document.getElementById('loader').style.visibility = "visible";
        //     // $("#loader").fadeIn("slow");
        // },
        success: function(result) {
            // document.getElementById('loader').style.visibility = "hidden";
            if (result["status"] == "success") {
                var state_data = result.state_data;
                var html = "";
                html += '<option value=""></option>';
                $.each(state_data, function(state_data_index, state_data_row) {
                    html += '<option value="' + state_data_row.id + '">' + state_data_row.name + "</option>";
                });
                $("#fk_state_id").html(html);
                $("#fk_state_id").trigger("chosen:updated");
            } else if (result["status"] == "failure") {
                $("#fk_state_id").html("");
                $("#fk_state_id").trigger("chosen:updated");
            } else if (result["status"] == "login_failure") {
                window.location.replace(result["url"]);
            } else {

            }
        },
    });
});
$(document).on("change", "#fk_state_id", function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "superadmin/get_city_data_on_state_id",
        data: {
            state_id: id
        },
        dataType: "json",
        cache: false,
        // beforeSend: function() {
        //     document.getElementById('loader').style.visibility = "visible";
        //     // $("#loader").fadeIn("slow");
        // },
        success: function(result) {
            // document.getElementById('loader').style.visibility = "hidden";
            if (result["status"] == "success") {
                var city_data = result.city_data;
                var html = "";
                html += '<option value=""></option>';
                $.each(city_data, function(city_data_index, city_data_row) {
                    html += '<option value="' + city_data_row.id + '">' + city_data_row.name + "</option>";
                });
                $("#fk_city_id").html(html);
                $("#fk_city_id").trigger("chosen:updated");
            } else if (result["status"] == "failure") {
                $("#fk_city_id").html("");
                $("#fk_city_id").trigger("chosen:updated");
            } else if (result["status"] == "login_failure") {
                window.location.replace(result["url"]);
            } else {

            }
        },
    });
});
$('#addRows').click(function() {

    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) + 1;

    var html2 = '';
    html2 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="from_hours[]" id="from_hours_' + new_count + '" placeholder="From Hours"> <span class="error_msg" id="from_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="to_hours[]" id="to_hours_' + new_count + '" placeholder="To Hours"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="price[]" id="price_' + new_count + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="price_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';

    $('#price_data_append').append(html2);

});
$(document).on('click', '#removeRow', function() {
    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) - 1;
    $('#count').val(new_count);
    $(this).closest("div").remove();
});
$('#add_parking_place_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_parking_place_form")[0]);
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
                $('form#add_parking_place_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#price_data_append').html('');
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
$(document).ready(function() {
    load_parking_place_data();
    $(".chosen-select-deselect").chosen({
                    width: "100%",
                });
});

function load_parking_place_data() {
    var dataTable = $('#parking_place_data_table').DataTable({
        // dom: 'lBfrtip',
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "ajax": {
            url: frontend_path + 'superadmin/display_all_parking_place',
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
            var hour_price_slab = data['hour_price_slab'];
            var state_details = data['state_details'];
            var city_details = data['city_details'];
            $("#edit_id").val(info['id']);
            $('#edit_fk_vendor_id').val(info['fk_vendor_id']);
            $('#edit_fk_vendor_id').trigger("chosen:updated");
            $('#edit_fk_country_id').val(info['fk_country_id']);
            $('#edit_fk_country_id').trigger("chosen:updated");
            $('#edit_place_name').val(info['place_name']);
            $('#edit_address').val(info['address']);
            $('#edit_pincode').val(info['pincode']);
            $('#edit_latitude').val(info['latitude']);
            $('#edit_longitude').val(info['longitude']);
            $('#edit_slots').val(info['slots']);
            $('#edit_fk_place_status_id').val(info['fk_place_status_id']);
            $('#edit_fk_place_status_id').trigger("chosen:updated");
            $('#edit_fk_parking_price_type').val(info['fk_parking_price_type']);
            $('#edit_fk_parking_price_type').trigger("chosen:updated");
            $('#edit_ext_price').val(info['ext_price']);
            var state_option = "";
            var option_data = "";
            $.each(state_details, function(state_details_index, state_details_row) {
                if (state_details_row["id"] == info['fk_state_id']) {
                    option_data = "selected";
                } else {
                    option_data = "";
                }
                state_option += "<option value=" + state_details_row["id"] + " " + option_data + " >" + state_details_row["name"] + "</option>";
            });
            $('#edit_fk_state_id').html(state_option);
            $('#edit_fk_state_id').trigger("chosen:updated");
            var city_option = "";
            var option_data1 = "";
            $.each(city_details, function(city_details_index, city_details_row) {
                if (city_details_row["id"] == info['fk_city_id']) {
                    option_data1 = "selected";
                } else {
                    option_data1 = "";
                }
                city_option += "<option value=" + city_details_row["id"] + " " + option_data1 + " >" + city_details_row["name"] + "</option>";
            });
            $('#edit_fk_city_id').html(city_option);
            $('#edit_fk_city_id').trigger("chosen:updated");
            var html = "";
            var machine_id = "";
            $.each(slot_info, function(slot_info_index, slot_info_row) {
                if (slot_info_row['fk_machine_id'] == null) {
                    machine_id = "";
                } else {
                    machine_id = slot_info_row['device_id'];
                }
                html += "<div class='row'><input type='hidden' name='edit_slot_id' id='edit_slot_id_" + slot_info_index + " value='" + slot_info_row['slot_info_id'] + "'><div class='col-md-4'><div class='form-group'><label>Slot Name</label><br><span class='data_fetch'>" + slot_info_row['slot_name'] + "</span></div></div><div class='col-md-4'><div class='form-group'><label>Display Id</label><br><span class='data_fetch'>" + slot_info_row['display_id'] + "</span></div></div><div class='col-md-4'><div class='form-group'><label>Machine Id</label><br><span class='data_fetch'>" + machine_id + "</span></div></div></div>";
            });
            $('#machine_details').html(html);
            var html3 = "";
            $.each(hour_price_slab, function(hour_price_slab_index, hour_price_slab_row) {
                html3 += "<div class='row'><input type='hidden' name='hour_price_slab_id[]' id='hour_price_slab_id_" + hour_price_slab_index + "' value='" + hour_price_slab_row['hour_price_slab_id'] + "'><div class='col-md-3'><div class='form-group'><label>From Hour</label><input class='form-control input-text' type='text' name='edit_from_hours[]' id='edit_from_hours_" + hour_price_slab_index + "' value='" + hour_price_slab_row['from_hours'] + "'></div></div><div class='col-md-3'><div class='form-group'><label>To Hour</label><input class='form-control input-text' type='text' name='edit_to_hours[]' id='edit_to_hours_" + hour_price_slab_index + "' value='" + hour_price_slab_row['to_hours'] + "'></div></div><div class='col-md-3'><div class='form-group'><label>Price</label><input class='form-control input-text' type='text' name='edit_price[]' id='edit_price_" + hour_price_slab_index + "' value='" + hour_price_slab_row['cost'] + "'></div></div></div>";
            });
            html3 += "<div class='row'><div class='col-md-12'> <button id='addRows_edit' type='button' class='btn btn-info' style='margin-top: 22px; margin-left: 860px;'><i class='icon-plus'></i> </button> <input type='hidden' class='form-control' name='edit_count' id='edit_count' value='0'> </div><div> <hr><div id='edit_price_data_append'></div>";
            $('#hour_price_details').html(html3);

            $('#addRows_edit').click(function() {

                var edit_latest_count = $('#edit_count').val();
                var edit_new_count = parseInt(edit_latest_count) + 1;

                var html4 = '';
                html4 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="edit_from_hours[]" id="edit_from_hours_' + edit_new_count + '" placeholder="From Hours"> <span class="error_msg" id="edit_from_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="edit_to_hours[]" id="edit_to_hours_' + edit_new_count + '" placeholder="To Hours"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_price[]" id="edit_price_' + edit_new_count + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="edit_price_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';

                $('#edit_price_data_append').append(html4);

            });
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
            $('#parking_place_data_table').DataTable().ajax.reload(null, false);

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

$('#update_place_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_place_details_form")[0]);
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
            $('#update_place_button').button('loading');
        },
        success: function(response) {
            $('#update_place_button').button('reset');
            if (response.status == 'success') {
                $('form#update_place_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#parking_place_data_table').DataTable().ajax.reload(null, false);
                $('#edit_place_modal').modal('hide');
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
        beforeSend: function() {
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