$(document).ready(function(){
    $("#user_type").change(function(){
        var user_type = $('#user_type').val();
        $("#user_type option:selected").each(function(){
            if($(this).attr("value")==1){
                $("#un_register_user_id").hide();
                $("#booking_id").show();
                $("#user_id").show();
            }
            if($(this).attr("value")== 2){
                $("#booking_id").hide();
                $("#user_id").hide();
                $("#un_register_user_id").show();
            }
            if(user_type == ""){
                 $("#un_register_user_id").hide();
                   $("#booking_id").hide();
                $("#user_id").hide();
            }                
        });
    }).change();
});

$('#add_complaint_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_complaint_form")[0]);
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
            $('#add_complaint_button').button('loading');
        },
        success: function(response) {
            $('#add_complaint_button').button('reset');
            if (response.status == 'success') {
                $('form#add_complaint_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#Complaint_register_table').DataTable().ajax.reload(null, false);
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
    register_user = $('#Complaint_register_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_register_user_complaint_data",
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
                "data": "place_name"
            },
            {
                "data": "booking_id",
            },
            {
                "data": "issue_type"
            },
             {
                "data": "description"
            },
            {
                "data": "status",
                render: function(data) {
                    var change_status = data;
                    if (change_status == 1) {
                        return 'Pending';
                    } else if (change_status == 2) {
                        return 'Process';
                    }else{
                          return 'Completed';
                    }
                },
            },
            {
                "data": "source_type",
                render: function(data) {
                    var source_type = data;
                    if (source_type == 1) {
                        return 'APP';
                    } else if (source_type == 2) {
                        return 'Direct Call';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_register_user",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_register_user_modal"></i></a></span>'
                // <span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#delete_complaint" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_complaint" aria-hidden="true"></i></a></span>
            },
        ],
        "order": [
            [0, 'desc']
        ]
    });
    register_user.on('order.dt search.dt', function() {
        register_user.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });

    }).draw();
});

$(document).on("click","#Complaint_register_table tbody tr, .edit_register_user tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = register_user.row(tr);
    var data1 = row.data();
    $('#user_name').text(data1.firstName+ " "+data1.lastName);
    $('#contact_no').text(data1.contact_no);
    $('#email').text(data1.email);
    $('#place_name').text(data1.place_name);
    $('#booking_ids').text(data1.booking_id);
    $('#booking_from').text(data1.booking_from_date +" "+data1.booking_from_time);
    $('#booking_to').text(data1.booking_to_date +" "+data1.booking_to_time);
    $('#issue_type').text(data1.issue_type);
    $('#description').text(data1.description);
    $('#car_no').text(data1.car_number);
    $('#slot_no').text(data1.display_id);
    $('#edit_id').val(data1.id);
    $('#action_type').val(data1.action_type);
    $('#action_type').trigger('chosen:updated');
    $('#customer_care_remark').val(data1.customer_care_remark);
    $('#complaint_status').val(data1.status);
    $('#complaint_status').trigger('chosen:updated');
  
   
});
$(document).ready(function() {
    table = $('#Complaint_un_register_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_unregister_user_complaint_data",
        "columns": [{
                "data": null
            },
            {
                "data": "user_name"
            },
            {
                "data": "contact_no"
            },
            {
                "data": "issue_type"
            },
            {
                "data": "description"
            },
            {
                "data": "status",
                render: function(data) {
                    var change_status = data;
                    if (change_status == 1) {
                        return 'Pending';
                    } else if (change_status == 2) {
                        return 'Process';
                    }else{
                          return 'Completed';
                    }
                },
            },
            {
                "data": "source_type",
                render: function(data) {
                    var source_type = data;
                    if (source_type == 1) {
                        return 'APP';
                    } else if (source_type == 2) {
                        return 'Direct Call';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_register_user",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_unregister_user_modal"></i></a></span>'
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
$(document).on("click","#Complaint_un_register_table tbody tr, .edit_register_user tbody tr td",function(){
    var tr_1 = $(this).closest('tr');
    var row_1 = table.row(tr_1);
    var data1_1 = row_1.data();
    // console.log(data1_1);
    $('#unr_user_name').text(data1_1.user_name);
    $('#unr_contact_no').text(data1_1.contact_no);    
    $('#unr_issue_type').text(data1_1.issue_type);
    $('#unr_description').text(data1_1.description);
    $('#unr_edit_id').val(data1_1.id);
    $('#unr_action_type').val(data1_1.action_type);
    $('#unr_action_type').trigger('chosen:updated');
    $('#unr_customer_care_remark').val(data1_1.customer_care_remark);
    $('#unr_complaint_status').val(data1_1.status);
    $('#unr_complaint_status').trigger('chosen:updated');
});

$('#update_register_user_complaint_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_register_user_complaint_form")[0]);
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
            $('#update_register_user_complaint_button').button('loading');
        },
        success: function(response) {
            $('#update_register_user_complaint_button').button('reset');
            if (response.status == 'success') {
                $('#Complaint_register_table').DataTable().ajax.reload(null, false);
                $('#edit_register_user_modal').modal('hide');
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
$('#update_unregister_user_complaint_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_unregister_user_complaint_form")[0]);
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
            $('#update_unregister_user_complaint_button').button('loading');
        },
        success: function(response) {
            $('#update_register_user_complaint_button').button('reset');
            if (response.status == 'success') {
                $('#Complaint_un_register_table').DataTable().ajax.reload(null, false);
                $('#edit_unregister_user_modal').modal('hide');
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