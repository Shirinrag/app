let simpletable = '';
$(document).ready(function() {
    simpletable = $('#booking_table').DataTable( {
        'ajax': {
            'url': frontend_path + 'reports/display_all_booking_report_data',
            'type': 'POST',
            "data": function (data) {
                data.from_date = $('#from_date').val();
                data.to_date = $('#to_date').val();
            }
        }, 
        dom: 'Bfrtip',           
        buttons: [
              // 'copy',
              'excel',
              // 'csv',
              'pdf',
              // 'print'
            ],
      
        "columns": [{
                "data": null
            },
            {
                "data": "booking_id"
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
                "data": "place_name",
            },
            {
                "data": "display_id",
            },
            {
                "data": "booking_from_date",
                "render": function ( data, type, row, meta ) {                  
                    var html="";
                     html= data+" "+row.booking_from_time;
                     return html;
                  },
            },
            {
                "data": "booking_to_date",
                "render": function ( data, type, row, meta ) {                  
                    var html ="";
                     html = data+" "+row.booking_to_time;                   
                     return html;
                  },
            },
            {
                "data": "total_amount",
            },
            {
                "data": "booking_status",
                render: function(data) {
                    var data_info = data;
                    if(data_info == "onprocess"){
                        return '<label class="badge badge-warning">' + data_info + '</label>';
                    }else if(data_info == "completed"){
                        return '<label class="badge badge-success">' + data_info + '</label>';
                    }else if(data_info == "cancelled"){
                        return '<label class="badge badge-danger">' + data_info + '</label>';
                    }
                },
            },
            
        ],
        "order": [
            [0, 'desc']
        ]
    });
    simpletable.on('order.dt search.dt', function() {
        simpletable.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });

    }).draw();
});
 $('#btn-search-by-date').click(function () { //button filter event click
        simpletable.ajax.reload(null, false); //just reload table
    });

