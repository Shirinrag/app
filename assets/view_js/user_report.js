let simpletable = '';
$(document).ready(function() {
    simpletable = $('#user_data_report_table').DataTable( {
        'ajax': {
            'url': frontend_path + 'reports/display_all_user_report_data',
            'type': 'POST',
            "data": function (data) {
                data.from_date = $('#from_date').val();
                data.to_date = $('#to_date').val();
                console.log(data);
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
      
        "columns": [
            { "data": null},
            { "data": "firstName"},
            { "data": "userName"},                  
            { "data": "email"},
            { "data": "phoneNo"},
            { "data": "car_number"},      
            { "data": "referral_code"},      
            { "data": "created_at"},      
        ],
        "order": [[ 0, 'desc' ]]       
      });   
      simpletable.on('order.dt search.dt', function() {
          simpletable.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
              cell.innerHTML = i + 1;
          });
  
      }).draw();
});
    $('#btn-search-by-date').click(function () { //button filter event click
        simpletable.ajax.reload(null, false); //just reload table
    });