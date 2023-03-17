let simpletable = '';
$(document).ready(function() {
    simpletable = $('#verifier_attendance_data_report_table').DataTable( {
        'ajax': {
            'url': frontend_path + 'reports/display_all_verifier_attendance_report_data',
            'type': 'POST',
            "data": function (data) {
                data.from_date = $('#from_date').val();
                data.to_date = $('#to_date').val();
                data.fk_verifier_id = $('#fk_verifier_id').val();
                data.fk_place_id = $('#fk_place_id').val();
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
      
        // "ajax": frontend_path+"reports/display_all_user_report_data",
        "columns": [
            { "data": null},
           {
                "data": "firstName",
                  "render": function ( data, type, row, meta ) {                  
                    var html="";
                     html= data+" "+row.lastName;
                     return html;
                  },
            },     
            { "data": "login_time"},      
            { "data": "logout_time"},      
            { "data": "place_name"},      
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