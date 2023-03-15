$(document).ready(function() {
    register_user = $('#slot_issue_data_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_slot_complaint_data",
        "columns": [{
                "data": null
            },
            {
                "data": "place_name",
                 "render": function ( data, type, row, meta ) {                  
                    var html="";
                     html= data+" "+row.address;
                     return html;
                  },
            },
            {
                "data": "display_id",
            },
            {
                "data": "created_at"
            },
            {
                "data": "complaint_text"
            },
           
            {
                "data": "source",
                render: function(data) {
                    var source_type = data;
                    if (source_type == 1) {
                        return 'Guide APP';
                    } else if (source_type == 2) {
                        return 'Direct Call';
                    }
                },
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






