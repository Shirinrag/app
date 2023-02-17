$(document).ready(function() {
    table = $('#suggested_parking_place_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_suggested_parking_place_data",
        "columns": [{
                "data": null
            },
            // {
            //     "data": "firstName",
            //       "render": function ( data, type, row, meta ) {                  
            //         var html="";
            //          html= data+" "+row.lastName;
            //          return html;
            //       },
            // },
            // {
            //     "data": "pos_device_id"
            // },
           
            {
                "data": "place_name"
            },
            {
                "data": "address"
            },
            {
                "data": "landmark"
            },
            {
                "data": "latitude"
            },
            {
                "data": "longitude"
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


