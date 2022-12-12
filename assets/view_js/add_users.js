$(document).ready(function() {
    table = $('#user_data_table').DataTable( {
        "ajax": frontend_path+"superadmin/display_all_user_data",
        "columns": [
            { "data": null},
            { "data": "firstName"},
            { "data": "userName"},                  
            { "data": "email"},
            { "data": "phoneNo"},
            { "data": "car_number"},
            { "data": "isVerified",
                // "className": "change_status",
                render: function(data) {
                    // console.log(data);
                    var data_info=data;
                    if (data_info == '1') {
                        return '<label class="badge badge-success">Verified</label>';
                    }else{
                        return '<label class="badge badge-danger">Not Verified</label>';
                    }
                },
            },
            // { "data": "status",
            //     "className": "change_status",
            //     render: function(data) {
            //         var data_info=data.split(",");
            //         if (data_info[0] == '1') {
            //             return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="switch'+data_info[1]+'" name="example" checked onclick="change_status('+data_info[0]+','+data_info[1]+');"><label class="custom-control-label" for="switch'+data_info[1]+'"></label></div>';
            //         } else {
            //             return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="switch'+data_info[1]+'" name="example" onclick="change_status('+data_info[0]+','+data_info[1]+');"><label class="custom-control-label" for="switch'+data_info[1]+'"></label></div>';
            //         }
            //     },
            // }, 
            
        ],
        "order": [[ 0, 'desc' ]]       
      });   
      table.on('order.dt search.dt', function() {
          table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
              cell.innerHTML = i + 1;
          });
  
      }).draw();
});
