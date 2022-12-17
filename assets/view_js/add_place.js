$(document).ready(function() {
    var id = $("#fk_country_id").val();
    $.ajax({
        type: "POST",
        url: frontend_path + "superadmin/get_state_data_on_country_id",
        data: { country_id: id },
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
        data: { country_id: id },
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
        data: { state_id: id },
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
          html2 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="from_hours[]" id="from_hours_'+new_count+'" placeholder="From Hours"> <span class="error_msg" id="from_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="to_hours[]" id="to_hours_'+new_count+'" placeholder="To Hours"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="price[]" id="price_'+new_count+'" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="price_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';   
   
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
        url: frontend_path + "superadmin/get_place_edit_info",
        method: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function(data) {
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
                $('#parking_place_data_table').DataTable().ajax.reload(null, false);
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