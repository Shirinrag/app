$(document).ready(function() {
    table = $('#user_data_report_table').DataTable( {
          "ajax": {
            "url": frontend_path+"reports/display_all_user_report_data",
            "data": function (data) {
            data.from_date = $('#from_date').val();
            data.to_date = $('#to_date').val();
        },
    },
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
                    var data_info=data;
                    if (data_info == '1') {
                        return '<label class="badge badge-success">Verified</label>';
                    }else{
                        return '<label class="badge badge-danger">Not Verified</label>';
                    }
                },
            },
            { "data": "statusdata",
                "className": "change_status",
                render: function(data) {
                    var change_status=data.split(",");
                    if (change_status[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch'+change_status[1]+'" onclick="change_status('+change_status[0]+','+change_status[1]+');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch'+change_status[1]+'" onclick="change_status('+change_status[0]+','+change_status[1]+');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                       
                    }
                },
            }, 
            
        ],
        "order": [[ 0, 'desc' ]]       
      });   
      table.on('order.dt search.dt', function() {
          table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
              cell.innerHTML = i + 1;
          });
  
      }).draw();

       $('#btn-search-by-date').click(function () { //button filter event click
        table.ajax.reload(null, false); //just reload table
    });
});