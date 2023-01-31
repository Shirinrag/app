$(document).ready(function() {
    table = $('#pos_booking_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_pos_booking_data",
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
                "data": "pos_device_id"
            },
           
            {
                "data": "place_name"
            },
            {
                "data": "car_no"
            },
            {
                "data": "phone_no"
            },
            {
                "data": "from_date"
            },
            {
                "data": "to_date"
            },
            {
                "data": "from_time"
            },
            {
                "data": "to_time"
            },
            {
                "data": "total_hours"
            },
            {
                "data": "price"
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


