$(document).ready(function () {
   var id = $("#fk_country_id").val();
   $.ajax({
      type: "POST",
      url: frontend_path + "superadmin/get_state_data_on_country_id",
      data: {
         country_id: id
      },
      dataType: "json",
      cache: false,
      success: function (result) {
         if (result["status"] == "success") {
            var state_data = result.state_data;
            var html = "";
            html += '<option value=""></option>';
            $.each(state_data, function (state_data_index, state_data_row) {
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
$(document).on("change", "#fk_country_id", function () {
   var id = $(this).val();
   $.ajax({
      type: "POST",
      url: frontend_path + "superadmin/get_state_data_on_country_id",
      data: {
         country_id: id
      },
      dataType: "json",
      cache: false,
      success: function (result) {
         if (result["status"] == "success") {
            var state_data = result.state_data;
            var html = "";
            html += '<option value=""></option>';
            $.each(state_data, function (state_data_index, state_data_row) {
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
$(document).on("change", "#fk_state_id", function () {
   var id = $(this).val();
   $.ajax({
      type: "POST",
      url: frontend_path + "superadmin/get_city_data_on_state_id",
      data: {
         state_id: id
      },
      dataType: "json",
      cache: false,
      success: function (result) {
         if (result["status"] == "success") {
            var city_data = result.city_data;
            var html = "";
            html += '<option value=""></option>';
            $.each(city_data, function (city_data_index, city_data_row) {
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
$('#place_count, #reserved_place_count').on('input', function () {
   var place_count = parseInt($('#place_count').val());
   var reserved_place_count = parseFloat($('#reserved_place_count').val());
   $('#total_place_count').val((place_count - reserved_place_count ? place_count - reserved_place_count : 0));
});

$('#edit_place_count, #edit_reserved_place_count').on('input', function () {
   var edit_place_count = parseInt($('#edit_place_count').val());
   var edit_reserved_place_count = parseFloat($('#edit_reserved_place_count').val());
   $('#edit_total_place_count').val((edit_place_count - edit_reserved_place_count ? edit_place_count - edit_reserved_place_count : 0));
});
$('#add_parking_place_form').submit(function (e) {
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
      beforeSend: function () {
         $('#add_parking_place_button').button('loading');
      },
      success: function (response) {
         $('#add_parking_place_button').button('reset');
         if (response.status == 'success') {
            $('form#add_parking_place_form').trigger('reset');
            $(".chosen-select-deselect").val('');
            $('.chosen-select-deselect').trigger("chosen:updated");
            $('#price_data_append').html('');
            $('#monthly_price_data_append').html('');
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
      error: function (error, message) {

      }
   });
   return false;
});
$(document).ready(function () {
   load_parking_place_data();
   $(".chosen-select-deselect").chosen({
      width: "100%",
   });
});

function load_parking_place_data() {
   var dataTable = $('#parking_place_data_table').DataTable({
      "columnDefs": [{
            "width": "10px",
            "targets": 0
         },
         {
            "width": "30px",
            "targets": 5
         },

      ],
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
$(document).on("click", ".edit_place_data", function () {
   var id = $(this).attr("id");
   $.ajax({
      url: frontend_path + "superadmin/get_parking_place_details_on_id",
      method: "POST",
      data: {
         id: id,
      },
      dataType: "json",
      success: function (data) {
         var info = data['parking_place_data'];
         var slot_info = data['slot_info'];
         var hour_price_slab = data['hour_price_slab'];
         var state_details = data['state_details'];
         var city_details = data['city_details'];
         var vehicle_type = data['vehicle_type'];
         var parking_place_vehicle_type = data['parking_place_vehicle_type'];
         var monthly_price_slab = data['monthly_price_slab'];
         var pass_days_data = data['pass_days_data'];
         var currency_data = data['currency_data'];
         // console.log(info);
         var selected_parking_place_vehicle_type = data['selected_parking_place_vehicle_type']['fk_vehicle_type_id'];
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
         $('#edit_per_hour_charges').val(info['per_hour_charges']);
         $('#edit_place_count').val(info['place_count']);
         $('#edit_reserved_place_count').val(info['reserved_place_count']);
         $('#edit_total_place_count').val(info['total_place_count']);
         $('#edit_referral_code').val(info['referral_code']);
         $('#edit_place_type').val(info['parking_place_type']);
         $('#edit_place_type').trigger("chosen:updated");
         $('#last_price_image').val(info['price_image']);
         $('#last_place_image').val(info['place_image']);
         var state_option = "";
         var option_data = "";
         $.each(state_details, function (state_details_index, state_details_row) {
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
         $.each(city_details, function (city_details_index, city_details_row) {
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
         var vehicle_type_option_data = "";
         var selected = "";
         $.each(vehicle_type, function (vehicle_type_index, vehicle_type_row) {
            if (jQuery.inArray(vehicle_type_row['id'], selected_parking_place_vehicle_type) !== -1) {
               vehicle_type_option_data += '<option value="' + vehicle_type_row['id'] + '" selected >' + vehicle_type_row['vehicle_type'] + '</option>';
               if (monthly_price_slab == "") {
                  var pass_days_data = data.pass_days_data;
                  var html_101 = '';
                  var html_111 = '';

                  var pass_data_option = "";
                  $.each(pass_days_data, function (pass_days_data_key, pass_days_data_row) {
                     pass_data_option += '<option value="' + pass_days_data_row['id'] + '">' + pass_days_data_row['no_of_days'] + '</option>'
                  });

                    var currency_option_data = "";
                    $.each(currency_data, function (currency_data_index, currency_data_row) {
                        currency_option_data += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + "</option>";
                    });
                  html_101 += '<div id="new_price_data_append1_' + vehicle_type_row['id'] + '"><div class="row"> <h4 class="card-title">' + vehicle_type_row['vehicle_type'] + " " + 'Monthly Price Slab</h4><div class="col-md-3"> <div class="form-group"> <label>No Of Days</label><select type="text" class="form-control chosen-select-deselect" name="edit_no_of_days_' + vehicle_type_row['id'] + '[]" id="edit_no_of_days_' + vehicle_type_row['id'] + '" data-placeholder="Monthly Price Slab"><option value=""></option>"' + pass_data_option + '"</select><span class="error_msg" id="no_of_days_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_cost_' + vehicle_type_row['id'] + '[]" id="edit_cost_' + vehicle_type_row['id'] + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="edit_cost_error"></span> </div></div><div class="col-md-3"><div class="form-group"><label>Select Currency</label><select type="text" class="form-control chosen-select-deselect" name="edit_currencys_'+ vehicle_type_row['id'] + '[]" id="edit_currencys_' + vehicle_type_row['id'] +'" data-placeholder="Select Currency"><option value=""></option>"' + currency_option_data + '"</select></div></div><div class="col-md-2"> <button id="addRowsMonthly_' + vehicle_type_row['id'] + '" type="button" class="btn btn-info" style="margin-top: 22px; margin-left: -20px;"><i class="icon-plus"></i> </button> <input type="hidden" class="form-control" name="count" id="monthly_count_' + vehicle_type_row['id'] + '" value="0"> </div></div> </div><div id="new_monthly_price_data_append_' + vehicle_type_row['id'] + '"></div>';
                  $('#edit_monthly_price_details').append(html_101);
                  $(".chosen-select-deselect").chosen({
                     width: "100%",
                  });
                  $('#addRowsMonthly_' + vehicle_type_row['id'] + '').click(function () {
                     var latest_count_1 = $('#monthly_count_' + vehicle_type_row['id'] + '').val();
                     var new_count_1 = parseInt(latest_count_1) + 1;
                      var currency_option_datas = "";
                    $.each(currency_data, function (currency_data_index, currency_data_row) {
                        currency_option_datas += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + "</option>";
                    });
             
                     html_111 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>No Of Days</label><select type="text" class="form-control chosen-select-deselect" name="edit_no_of_days_' + vehicle_type_row['id'] + '[]" id="edit_no_of_days_' + new_count_1 + '" data-placeholder="Monthly Price Slab"><option value=""></option>"' + pass_data_option + '"</select></div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_cost_' + vehicle_type_row['id'] + '[]" id="edit_cost_' + new_count_1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="edit_cost_error"></span> </div></div><div class="col-md-3"><div class="form-group"><label>Select Currency</label><select type="text" class="form-control chosen-select-deselect" name="edit_currencys_'+ vehicle_type_row['id'] + '[]" id="edit_currencys_' + vehicle_type_row['id'] +'" data-placeholder="Select Currency"><option value=""></option>"' + currency_option_datas + '"</select></div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';
                     $('#new_monthly_price_data_append_' + vehicle_type_row['id'] + '').append(html_111);
                     $(".chosen-select-deselect").chosen({
                        width: "100%",
                     });
                  });
                  $(document).on('click', '#removeRow', function () {
                     var latest_count_1 = $('#monthly_count_' + vehicle_type_row['id'] + '').val();
                     var new_count_1 = parseInt(latest_count_1) - 1;
                     $('#monthly_count_' + vehicle_type_row['id'] + '').val(new_count_1);
                     $(this).closest("div").remove();
                  });
               }
            } else {
               vehicle_type_option_data += '<option value="' + vehicle_type_row['id'] + '">' + vehicle_type_row['vehicle_type'] + '</option>';
            }
         });
         $('#edit_fk_vehicle_type').html(vehicle_type_option_data);
         $('#edit_fk_vehicle_type').trigger("chosen:updated");
         $.each(slot_info, function (slot_info_index, slot_info_row) {
            if (slot_info_row['fk_machine_id'] == null) {
               machine_id = "";
            } else {
               machine_id = slot_info_row['device_id'];
            }
            html += "<div class='row'><input type='hidden' name='edit_slot_id' id='edit_slot_id_" + slot_info_index + " value='" + slot_info_row['slot_info_id'] + "'><div class='col-md-4'><div class='form-group'><label>Slot Name</label><br><span class='data_fetch'>" + slot_info_row['slot_name'] + "</span></div></div><div class='col-md-4'><div class='form-group'><label>Display Id</label><br><span class='data_fetch'>" + slot_info_row['display_id'] + "</span></div></div><div class='col-md-4'><div class='form-group'><label>Machine Id</label><br><span class='data_fetch'>" + machine_id + "</span></div></div></div>";
         });
         $('#machine_details').html(html);
         var html3 = "";
         $.each(hour_price_slab, function (hour_price_slab_index, hour_price_slab_row) {
            var hour_id = hour_price_slab_row.id;
            var from_hours = hour_price_slab_row.from_hours;
            var to_hours = hour_price_slab_row.to_hours;
            var cost = hour_price_slab_row.cost;
            var fk_currency_id = hour_price_slab_row.fk_currency_id;
            var hour_id_1 = hour_id.split(",");
            var from_hours_1 = from_hours.split(',');
            var to_hours_1 = to_hours.split(',');
            var cost_1 = cost.split(',');
            if (fk_currency_id != null) {
               var fk_currency_id_1 = fk_currency_id.split(',');

            }
            html3 += hour_price_slab_row['vehicle_type'] + ' slabs';
            $.each(hour_id_1, function (hour_id_1_index, hour_id_1_row) {
               var currency_datas_1 = "";
               $.each(currency_data, function (currency_data_index, currency_data_row) {

                  if (typeof (fk_currency_id_1) !== 'undefined') {
                     if (currency_data_row['id'] == fk_currency_id_1[hour_id_1_index]) {
                        currency_datas_1 += '<option value="' + currency_data_row['id'] + '" selected>' + currency_data_row['currency_symbol'] + "</option>";
                     } else {
                        currency_datas_1 += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + "</option>";
                     }
                  } else {
                     currency_datas_1 += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + "</option>";
                  }
               });

               html3 += "<div class='row'><input type='hidden' name='hour_price_slab_id_" + hour_price_slab_row['fk_vehicle_type_id'] + "[]' id='hour_price_slab_id_" + hour_id_1_index + "' value='" + hour_id_1_row + "'><div class='col-md-3'><div class='form-group'><label>From Hour</label><input class='form-control input-text' type='text' name='edit_from_hours_" + hour_price_slab_row['fk_vehicle_type_id'] + "[]' id='edit_from_hours_" + hour_id_1_index + "' value='" + from_hours_1[hour_id_1_index] + "'></div></div><div class='col-md-3'><div class='form-group'><label>To Hour</label><input class='form-control input-text' type='text' name='edit_to_hours_" + hour_price_slab_row['fk_vehicle_type_id'] + "[]' id='edit_to_hours_" + hour_id_1_index + "' value='" + to_hours_1[hour_id_1_index] + "'></div></div><div class='col-md-3'><div class='form-group'><label>Price</label><input class='form-control input-text' type='text' name='edit_price_" + hour_price_slab_row['fk_vehicle_type_id'] + "[]' id='edit_price_" + hour_id_1_index + "' value='" + cost_1[hour_id_1_index] + "'></div></div><div class='col-md-3'><div class='form-group'><label>Select Currency</label><select type='text' class='form-control chosen-select-deselect' name='edit_currency_" + hour_price_slab_row['fk_vehicle_type_id'] + "[]' id='edit_currency_" + hour_id_1_index + "' data-placeholder='Select Currency'><option value=''></option>" + currency_datas_1 + "</select></div></div></div>";
            });
            var custom_class = '';
            custom_class += hour_price_slab_row['vehicle_type'].replace(" ", "_");
            custom_class += '_' + hour_price_slab_row['fk_vehicle_type_id'];
            html3 += '<div class="row"><div class="col-md-12"> <button class="addRows_edit btn btn-primary btn-sm" id="' + custom_class + '" type="button" class="btn btn-info" style="margin-top: 22px; margin-left: 860px;"><i class="icon-plus"></i> </button> <input type="hidden" class="form-control" name="edit_count_' + custom_class + '" id="edit_count_' + custom_class + '" value="0"> </div><div><div class ="edit_slab_add_more" id="edit_price_data_append_' + custom_class + '"></div> <hr>';
         });
         $('#hour_price_details').html(html3);
         $(".chosen-select-deselect").chosen({
            width: "100%",
         });
         var html_5 = '';
         $.each(monthly_price_slab, function (monthly_price_slab_index, monthly_price_slab_row) {
            var monthly_id = monthly_price_slab_row.id;
            var no_of_days = monthly_price_slab_row.no_of_days;
            var cost1 = monthly_price_slab_row.cost;
            var monthly_id_1 = monthly_id.split(",");
            var no_of_days_1 = no_of_days.split(',');
            var cost_2 = cost1.split(',');
            html_5 += monthly_price_slab_row['vehicle_type'] + ' slabs';
            $.each(monthly_id_1, function (monthly_id_1_index, monthly_id_1_row) {
               var no_of_days_data = "";
               $.each(pass_days_data, function (pass_days_data_index, pass_days_data_row) {
                  if (pass_days_data_row['id'] == no_of_days_1[monthly_id_1_index]) {
                     no_of_days_data += '<option value="' + pass_days_data_row['id'] + '" selected>' + pass_days_data_row['no_of_days'] + "</option>";
                  } else {
                     no_of_days_data += '<option value="' + pass_days_data_row['id'] + '">' + pass_days_data_row['no_of_days'] + "</option>";
                  }
               });

                var currency_datas_12 = "";
               $.each(currency_data, function (currency_data_index, currency_data_row) {

                  if (typeof (fk_currency_id_1) !== 'undefined') {
                     if (currency_data_row['id'] == fk_currency_id_1[hour_id_1_index]) {
                        currency_datas_12 += '<option value="' + currency_data_row['id'] + '" selected>' + currency_data_row['currency_symbol'] + "</option>";
                     } else {
                        currency_datas_12 += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + "</option>";
                     }
                  } else {
                     currency_datas_12 += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + "</option>";
                  }
               });
               html_5 += "<div class='row'><input type='hidden' name='edit_monthly_price_slab_id_" + monthly_price_slab_row['fk_vehicle_type_id'] + "[]' id='monthly_price_slab_id_" + monthly_id_1_index + "' value='" + monthly_id_1_row + "'><div class='col-md-3'><div class='form-group'><label>No of Days</label><select type='text' class='form-control chosen-select-deselect' name='edit_no_of_days_" + monthly_price_slab_row['fk_vehicle_type_id'] + "[]' id='edit_no_of_days_" + monthly_id_1_index + "' data-placeholder='Monthly Price Slab'><option value=''></option>" + no_of_days_data + "</select></div></div><div class='col-md-3'><div class='form-group'><label>Price</label><input class='form-control input-text' type='text' name='edit_cost_" + monthly_price_slab_row['fk_vehicle_type_id'] + "[]' id='edit_cost_" + monthly_id_1_index + "' value='" + cost_2[monthly_id_1_index] + "'></div></div><div class='col-md-3'><div class='form-group'><label>Select Currency</label><select type='text' class='form-control chosen-select-deselect' name='edit_currencys_" + monthly_price_slab_row['fk_vehicle_type_id'] + "[]' id='edit_currencys_" + monthly_id_1_index + "' data-placeholder='Select Currency'><option value=''></option>" + currency_datas_12 + "</select></div></div></div>";
            });
            var custom_class_1 = '';
            custom_class_1 += monthly_price_slab_row['vehicle_type'].replace(" ", "_");
            custom_class_1 += '_' + monthly_price_slab_row['fk_vehicle_type_id'];
            html_5 += '<div class="row"><div class="col-md-12"> <button class="addRowsMonthly_edit btn btn-primary btn-sm" id="' + custom_class_1 + '" type="button"style="margin-top: 22px; margin-left: 860px;"><i class="icon-plus"></i> </button> <input type="hidden" class="form-control" name="edit_count_monthly_' + custom_class_1 + '" id="edit_count_monthly_' + custom_class_1 + '" value="0"> </div><div><div class ="edit_monthly_price_slab_add_more" id="edit_monthly_price_data_append_' + custom_class_1 + '"></div> <hr>';
         });
         $('#monthly_price_details').html(html_5);
         $(".chosen-select-deselect").chosen({
            width: "100%",
         });
         if (info['price_image'] !== "") {
            var image = '';
            image = '<img src="' + frontend_path + info['price_image'] + '" class="" width="150px" height="150px">';
            $('#price_image_data').html(image);
         }
         if (info['place_image'] !== "") {
            var place_image = '';
            place_image = '<img src="' + frontend_path + info['place_image'] + '" class="" width="150px" height="150px">';
            $('#edit_place_image_data').html(place_image);
         }

      },
   });
});
$(document).on('click', '.addRows_edit', function () {
   var custom_id = $(this).attr('id');
   var custom_id_1 = custom_id.split('_');
   var edit_latest_count = $('#edit_count_' + custom_id).val();
   var edit_new_count = parseInt(edit_latest_count) + 1;
   $('#edit_count_' + custom_id).val(edit_new_count);
   var custom_id_mothly = $(this).attr('id');
   var custom_id_monthly_1 = custom_id_mothly.split('_');
   $.ajax({
      url: frontend_path + 'superadmin/get_vehicle_details',
      type: 'post',
      dataType: "json",
      data: {
         vehicle_id: custom_id_monthly_1[2]
      },
      success: function (response) {
         if (response["status"] == "success") {
            var currency_data = response.currency_data;
            var currency_data_option = "";
            $.each(currency_data, function (currency_data_key, currency_data_row) {
               currency_data_option += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + '</option>';
            });
            var html4 = '';
            html4 += '<div class="row"><div class="col-md-2"><div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="edit_from_hours_' + custom_id_1[2] + '[]" id="edit_from_hours_' + edit_new_count + '" placeholder="From Hours"> <span class="error_msg" id="edit_from_hours_error"></span> </div></div><div class="col-md-2"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="edit_to_hours_' + custom_id_1[2] + '[]" id="edit_to_hours_' + edit_new_count + '" placeholder="To Hours"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-2"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_price_' + custom_id_1[2] + '[]" id="edit_price_' + edit_new_count + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="edit_price_error"></span> </div></div><div class="col-md-2"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="edit_currency_' + custom_id_1[2] + '[]" id="edit_currency_' + edit_new_count + '" data-placeholder="Select Currency "><option value=""></option>"' + currency_data_option + '"</select> <span class="error_msg" id="price_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';
            $('#edit_price_data_append_' + custom_id).append(html4);
            $(".chosen-select-deselect").chosen({
               width: "100%",
            });
         }
      },
   });
});
$(document).on('click', '#removeRow', function () {
   var latest_count = $('#count').val();
   var new_count = parseInt(latest_count) - 1;
   $('#count').val(new_count);
   $(this).closest("div").remove();
});

$(document).on('click', '.addRowsMonthly_edit', function () {
   var custom_id_mothly = $(this).attr('id');
   var custom_id_monthly_1 = custom_id_mothly.split('_');
   var edit_latest_count_1 = $('#edit_count_monthly_' + custom_id_mothly).val();
   var edit_new_count_1 = parseInt(edit_latest_count_1) + 1;
   $('#edit_count_monthly_' + custom_id_mothly).val(edit_new_count_1);
   $.ajax({
      url: frontend_path + 'superadmin/get_vehicle_details',
      type: 'post',
      dataType: "json",
      data: {
         vehicle_id: custom_id_monthly_1[2]
      },
      success: function (response) {
         if (response["status"] == "success") {
            // var html = "";
            // var html_1 = "";
            var html_22 = "";
            var vehicle_id11 = response.vehicle_data.id;
            var pass_data11 = response.pass_days_data;

            var pass_data_option11 = "";
            $.each(pass_data11, function (pass_data11_key, pass_data11_row) {
               pass_data_option11 += '<option value="' + pass_data11_row['id'] + '">' + pass_data11_row['no_of_days'] + '</option>'
            });

            var currency_data = response.currency_data;
            var currency_data_option = "";
            $.each(currency_data, function (currency_data_key, currency_data_row) {
               currency_data_option += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + '</option>';
            });
            html_22 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>No Of Days</label><select type="text" class="form-control chosen-select-deselect" name="edit_no_of_days_' + vehicle_id11 + '[]" id="edit_no_of_days_' + edit_new_count_1 + '" data-placeholder="Monthly Price Slab"><option value=""></option>"' + pass_data_option11 + '"</select></div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_cost_' + vehicle_id11 + '[]" id="edit_cost_' + edit_new_count_1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="cost_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="edit_currencys_' + vehicle_id11 + '[]" id="edit_currencys_' + edit_new_count_1 + '" data-placeholder="Select Currency "><option value=""></option>"' + currency_data_option + '"</select> <span class="error_msg" id="edit_currencys"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';
            $('#edit_monthly_price_data_append_' + custom_id_mothly + '').append(html_22);
            $(".chosen-select-deselect").chosen({
               width: "100%",
            });
         }
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
      success: function (data) {
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

$('#update_place_details_form').submit(function (e) {
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
      beforeSend: function () {
         $('#update_place_button').button('loading');
      },
      success: function (response) {
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
      error: function (error, message) {

      }
   });
   return false;
});

$("#delete-form").on('submit', (function (e) {
   e.preventDefault();
   $.ajax({
      url: frontend_path + "superadmin/delete_admin",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      dataType: 'json',
      beforeSend: function () {
         $('#admin_del_button').button('loading');
      },
      success: function (data) {
         $('form#delete-form').trigger('reset');
         $('#parking_place_data_table').DataTable().ajax.reload(null, false);
         swal({
            title: "success",
            text: data.message,
            icon: "success",
            dangerMode: true,
            timer: 1500
         });
         $("#delete_admin").modal('hide');
         $('#admin_del_button').button('reset');
      }
   });
}));

$(document).on('change', '.update_parking_status', function () {
   var id = $(this).attr("id");
   var status = this.value;
   $.ajax({
      url: frontend_path + 'superadmin/update_parking_status',
      method: "POST",
      data: {
         id: id,
         status: status,
      },
      dataType: "json",
      success: function (data) {
         if (data.status == 1) {
            swal({
               title: "success",
               text: data.message,
               icon: "success",
               dangerMode: true,
               timer: 1500
            });
            $('#parking_place_data_table').DataTable().ajax.reload(null, false);
         } else if (data.status == 0) {
            $('#parking_place_data_table').DataTable().ajax.reload(null, false);
            swal({
               title: "success",
               text: data.message,
               icon: "success",
               dangerMode: true,
               timer: 1500
            });
         } else {
            window.location.replace(response['url']);
         }
      }
   });
});

$('#excel_import_pincode_form').submit(function (e) {
   e.preventDefault();
   var formData = new FormData($("#excel_import_pincode_form")[0]);
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
         $('#add_excel_parking_place_button').button('loading');
      },
      success: function (response) {

         if (response.status == 'success') {
            $('#add_excel_parking_place_button').button('reset');

            $('form#excel_import_pincode_form').trigger('reset');

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
      error: function (error, message) {

      }
   });
   return false;
});
$('#fk_vehicle_type').on('change', function (evt, params) {
   var vehicle_id = params.selected;
   var vehicle_id_deselected = params.deselected;
   if (vehicle_id) {
      $.ajax({
         url: frontend_path + 'superadmin/get_vehicle_details',
         type: 'post',
         dataType: "json",
         data: {
            vehicle_id: vehicle_id
         },
         success: function (response) {
            if (response["status"] == "success") {
               var html = "";
               var html_1 = "";
               var vehicle_id1 = response.vehicle_data.id;
               var pass_data = response.pass_days_data;
               var currency_data = response.currency_data;

               var currency_data_option = "";
               $.each(currency_data, function (currency_data_key, currency_data_row) {
                  currency_data_option += '<option value="' + currency_data_row['id'] + '">' + currency_data_row['currency_symbol'] + '</option>';
               });

               html += '<div id="new_price_data_append1_' + vehicle_id1 + '"><div class="row"> <h4 class="card-title">' + response.vehicle_data.vehicle_type + ' Price Slab</h4><div class="col-md-3"> <div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="from_hours_' + vehicle_id1 + '[]" id="from_hours_' + vehicle_id1 + '" placeholder="From Hours" onkeypress="return isNumber(event)"> <span class="error_msg" id="from_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="to_hours_' + vehicle_id1 + '[]" id="to_hours_' + vehicle_id1 + '" placeholder="To Hours" onkeypress="return isNumber(event)"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="price_' + vehicle_id1 + '[]" id="price_' + vehicle_id1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="price_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="currency_' + vehicle_id1 + '[]" id="currency_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + currency_data_option + '"</select> <span class="error_msg" id="price_error"></span> </div></div><div class="col-md-2"> <button id="addRows_' + vehicle_id1 + '" type="button" class="btn btn-info" style="margin-top: 22px; margin-left: -20px;"><i class="icon-plus"></i> </button> <input type="hidden" class="form-control" name="count" id="count_' + vehicle_id1 + '" value="0"> </div></div> </div><div id="new_price_data_append_' + vehicle_id1 + '"></div>';
               $('#price_data_append').append(html);

               $('#addRows_' + vehicle_id1 + '').click(function () {
                  var latest_count = $('#count_' + vehicle_id1 + '').val();
                  var new_count = parseInt(latest_count) + 1;
                  var html2 = '';
                  html2 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="from_hours_' + vehicle_id1 + '[]" id="from_hours_' + new_count + '" placeholder="From Hours"> <span class="error_msg" id="from_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="to_hours_' + vehicle_id1 + '[]" id="to_hours_' + new_count + '" placeholder="To Hours"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="price_' + vehicle_id1 + '[]" id="price_' + new_count + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="price_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="currency_' + vehicle_id1 + '[]" id="currency_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + currency_data_option + '"</select></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';
                  $('#new_price_data_append_' + vehicle_id1 + '').append(html2);
                  $(".chosen-select-deselect").chosen({
                     width: "100%",
                  });
               });
               $(document).on('click', '#removeRow', function () {
                  var latest_count = $('#count_' + vehicle_id1 + '').val();
                  var new_count = parseInt(latest_count) - 1;
                  $('#count_' + vehicle_id1 + '').val(new_count);
                  $(this).closest("div").remove();
               });
               var pass_data_option = "";
               $.each(pass_data, function (pass_data_key, pass_data_row) {
                  pass_data_option += '<option value="' + pass_data_row['id'] + '">' + pass_data_row['no_of_days'] + '</option>'
               });
               html_1 += '<div id="new_price_data_append1_' + vehicle_id1 + '"><div class="row"> <h4 class="card-title">' + response.vehicle_data.vehicle_type + " " + 'Monthly Price Slab</h4><div class="col-md-3"> <div class="form-group"> <label>No Of Days</label><select type="text" class="form-control chosen-select-deselect" name="no_of_days_' + vehicle_id1 + '[]" id="no_of_days_' + vehicle_id1 + '" data-placeholder="Monthly Price Slab"><option value=""></option>"' + pass_data_option + '"</select><span class="error_msg" id="no_of_days_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="cost_' + vehicle_id1 + '[]" id="cost_' + vehicle_id1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="cost_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="currencys_' + vehicle_id1 + '[]" id="currencys_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + currency_data_option + '"</select><span class="error_msg" id="cost_error"></span> </div></div><div class="col-md-2"> <button id="addRowsMonthly_' + vehicle_id1 + '" type="button" class="btn btn-info" style="margin-top: 22px; margin-left: -20px;"><i class="icon-plus"></i> </button> <input type="hidden" class="form-control" name="count" id="monthly_count_' + vehicle_id1 + '" value="0"> </div></div> </div><div id="new_monthly_price_data_append_' + vehicle_id1 + '"></div>';
               $('#monthly_price_data_append').append(html_1);
               $(".chosen-select-deselect").chosen({
                  width: "100%",
               });
               $('#addRowsMonthly_' + vehicle_id1 + '').click(function () {
                  var latest_count_1 = $('#monthly_count_' + vehicle_id1 + '').val();
                  var new_count_1 = parseInt(latest_count_1) + 1;
                  var html_2 = '';
                  html_2 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>No Of Days</label><select type="text" class="form-control chosen-select-deselect" name="no_of_days_' + vehicle_id1 + '[]" id="no_of_days_' + new_count_1 + '" data-placeholder="Monthly Price Slab"><option value=""></option>"' + pass_data_option + '"</select></div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="cost_' + vehicle_id1 + '[]" id="cost_' + new_count_1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="cost_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="currency_' + vehicle_id1 + '[]" id="currency_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + currency_data_option + '"</select><span class="error_msg" id="cost_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';
                  $('#new_monthly_price_data_append_' + vehicle_id1 + '').append(html_2);
                  $(".chosen-select-deselect").chosen({
                     width: "100%",
                  });
               });
               $(document).on('click', '#removeRow', function () {
                  var latest_count_1 = $('#monthly_count_' + vehicle_id1 + '').val();
                  var new_count_1 = parseInt(latest_count_1) - 1;
                  $('#monthly_count_' + vehicle_id1 + '').val(new_count_1);
                  $(this).closest("div").remove();
               });
            }

         },
      });
   } else if (vehicle_id_deselected) {
      $('#addRows_' + vehicle_id_deselected).remove();
      $('#new_price_data_append_' + vehicle_id_deselected + '').remove();
      $('#new_price_data_append1_' + vehicle_id_deselected + '').remove();
      // $('#monthly_price_data_append').remove();
   }
});

$('#edit_fk_vehicle_type').on('change', function (evt, params) {
   var vehicle_id = params.selected;
   var vehicle_id_deselected = params.deselected;
   if (vehicle_id) {
      $.ajax({
         url: frontend_path + 'superadmin/get_vehicle_details',
         type: 'post',
         dataType: "json",
         data: {
            vehicle_id: vehicle_id
         },
         success: function (response) {
            if (response["status"] == "success") {
               var html = "";
               var vehicle_id1 = response.vehicle_data.id;
               var pass_days_data = response.pass_days_data;
               var currency_data_1 = response.currency_data;

               var edit_currency_data_option = "";
               $.each(currency_data_1, function (currency_data_1_key, currency_data_1_row) {
                  edit_currency_data_option += '<option value="' + currency_data_1_row['id'] + '">' + currency_data_1_row['currency_symbol'] + '</option>';
               });

               var html_10 = '';
               var html_11 = '';
               html += '<div id="new_price_data_append1_' + vehicle_id1 + '"><div class="row"> <h4 class="card-title">' + response.vehicle_data.vehicle_type + ' Price Slab</h4><div class="col-md-3"> <div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="edit_from_hours_' + vehicle_id1 + '[]" id="edit_from_hours_' + vehicle_id1 + '" placeholder="From Hours" onkeypress="return isNumber(event)"> <span class="error_msg" id="from_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="edit_to_hours_' + vehicle_id1 + '[]" id="edit_to_hours_' + vehicle_id1 + '" placeholder="To Hours" onkeypress="return isNumber(event)"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_price_' + vehicle_id1 + '[]" id="edit_price_' + vehicle_id1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="edit_price_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="edit_currency_' + vehicle_id1 + '[]" id="edit_currency_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + edit_currency_data_option + '"</select> <span class="error_msg" id="edit_currency_error"></span> </div></div><div class="col-md-2"> <button id="addRows_' + vehicle_id1 + '" type="button" class="btn btn-info" style="margin-top: 22px; margin-left: -20px;"><i class="icon-plus"></i> </button> <input type="hidden" class="form-control" name="count" id="count_' + vehicle_id1 + '" value="0"> </div></div> </div><div id="new_price_data_append_' + vehicle_id1 + '"></div>';

               $('#edit_hour_price_details').append(html);

               $('#addRows_' + vehicle_id1 + '').click(function () {

                  var latest_count = $('#count_' + vehicle_id1 + '').val();
                  var new_count = parseInt(latest_count) + 1;

                  var html2 = '';

                  html2 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>From Hours</label> <input type="text" class="form-control input-text" name="edit_from_hours_' + vehicle_id1 + '[]" id="edit_from_hours_' + new_count + '" placeholder="From Hours"> <span class="error_msg" id="edit_from_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>To Hours</label> <input type="text" class="form-control input-text" name="edit_to_hours_' + vehicle_id1 + '[]" id="edit_to_hours_' + new_count + '" placeholder="To Hours"> <span class="error_msg" id="to_hours_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_price_' + vehicle_id1 + '[]" id="edit_price_' + new_count + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="price_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="edit_currency_' + vehicle_id1 + '[]" id="edit_currency_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + edit_currency_data_option + '"</select> <span class="error_msg" id="price_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';

                  $('#new_price_data_append_' + vehicle_id1 + '').append(html2);
                  $(".chosen-select-deselect").chosen({
                     width: "100%",
                  });

               });

               var pass_data_option = "";
               $.each(pass_days_data, function (pass_days_data_key, pass_days_data_row) {
                  pass_data_option += '<option value="' + pass_days_data_row['id'] + '">' + pass_days_data_row['no_of_days'] + '</option>'
               });

               html_10 += '<div id="new_price_data_append1_' + vehicle_id1 + '"><div class="row"> <h4 class="card-title">' + response.vehicle_data.vehicle_type + " " + 'Monthly Price Slab</h4><div class="col-md-3"> <div class="form-group"> <label>No Of Days</label><select type="text" class="form-control chosen-select-deselect" name="edit_no_of_days_' + vehicle_id1 + '[]" id="edit_no_of_days_' + vehicle_id1 + '" data-placeholder="Monthly Price Slab"><option value=""></option>"' + pass_data_option + '"</select><span class="error_msg" id="edit_no_of_days_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_cost_' + vehicle_id1 + '[]" id="edit_cost_' + vehicle_id1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="edit_cost_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="edit_currencys_' + vehicle_id1 + '[]" id="edit_currencys_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + edit_currency_data_option + '"</select> <span class="error_msg" id="price_error"></span> </div></div><div class="col-md-2"> <button id="addRowsMonthly_' + vehicle_id1 + '" type="button" class="btn btn-info" style="margin-top: 22px; margin-left: -20px;"><i class="icon-plus"></i> </button> <input type="hidden" class="form-control" name="count" id="monthly_count_' + vehicle_id1 + '" value="0"> </div></div> </div><div id="new_monthly_price_data_append_' + vehicle_id1 + '"></div>';
               $('#edit_monthly_price_details').append(html_10);
               $(".chosen-select-deselect").chosen({
                  width: "100%",
               });
               $('#addRowsMonthly_' + vehicle_id1 + '').click(function () {
                  var latest_count_1 = $('#monthly_count_' + vehicle_id1 + '').val();
                  var new_count_1 = parseInt(latest_count_1) + 1;

                  html_11 += '<div class="row"><div class="col-md-3"><div class="form-group"> <label>No Of Days</label><select type="text" class="form-control chosen-select-deselect" name="edit_no_of_days_' + vehicle_id1 + '[]" id="edit_no_of_days_' + new_count_1 + '" data-placeholder="Monthly Price Slab"><option value=""></option>"' + pass_data_option + '"</select></div></div><div class="col-md-3"> <div class="form-group"> <label>Price</label> <input type="text" class="form-control input-text" name="edit_cost_' + vehicle_id1 + '[]" id="edit_cost_' + new_count_1 + '" placeholder="Price" onkeypress="return isNumber(event)"> <span class="error_msg" id="edit_cost_error"></span> </div></div><div class="col-md-3"> <div class="form-group"> <label>Currency</label> <select type="text" class="form-control chosen-select-deselect" name="edit_currencys_' + vehicle_id1 + '[]" id="edit_currencys_' + vehicle_id1 + '" data-placeholder="Select Currency "><option value=""></option>"' + edit_currency_data_option + '"</select> <span class="error_msg" id="price_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 36px; width: 38px;">-</button></div>';
                  $('#new_monthly_price_data_append_' + vehicle_id1 + '').append(html_11);
                  $(".chosen-select-deselect").chosen({
                     width: "100%",
                  });
               });
               $(document).on('click', '#removeRow', function () {
                  var latest_count_1 = $('#monthly_count_' + vehicle_id1 + '').val();
                  var new_count_1 = parseInt(latest_count_1) - 1;
                  $('#monthly_count_' + vehicle_id1 + '').val(new_count_1);
                  $(this).closest("div").remove();
               });
            }

         },
      });
   } else if (vehicle_id_deselected) {
      $('#addRows_' + vehicle_id_deselected).remove();
      $('#new_price_data_append_' + vehicle_id_deselected + '').remove();
      $('#new_price_data_append1_' + vehicle_id_deselected + '').remove();
   }
});


$(document).ready(function () {
   var edit_fk_vehicle_type = $('#edit_fk_vehicle_type').val();
});