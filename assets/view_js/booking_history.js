$(document).ready(function() {
    table = $('#booking_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_booking_data",
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
                 "render": function ( data, type, row, meta ) {                  
                    var html="";

                     html+= data+" "+row.address +", ";
                     html+='</br>'; 
                     html+=data+", "+row.state_name; 
                     html+='</br>';
                     html+=data+" "+row.city_name+", "+data+", "+row.pincode;
                     
                     return html;
                  },
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
            {
                "data": "total_amount",
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

$(document).ready(function() {
    extend_booking_table = $('#extend_booking_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_extend_booking_data",
        "columns": [{
                "data": null
            },
            {
                "data": "booking_id"
            },
            {
                "data": "ext_booking_from_date",
                "render": function ( data, type, row, meta ) {                  
                    var html="";
                     html = data+" "+row.ext_booking_from_time;
                     return html;
                  },
            },
            {
                "data": "ext_booking_to_date",
                "render": function ( data, type, row, meta ) {                  
                    var html ="";
                     html = data+" "+row.ext_booking_to_time;                   
                     return html;
                  },
            },
            {
                "data": "total_amount",
            },
        ],
        "order": [
            [0, 'desc']
        ]
    });
    extend_booking_table.on('order.dt search.dt', function() {
        extend_booking_table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });

    }).draw();
});

