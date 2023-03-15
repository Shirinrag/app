$(document).ready(function() {
var simpletable = $('#user_data_report_table').DataTable({
       dom: 'lBfrtip',
         buttons: [
             'excel', 'pdf'
        ],
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'language': {
        'processing': '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
    },
    'ajax': {
        'url': frontend_path + 'reports/display_all_user_report_data',
        "data": function (data) {
            data.from_date = $('#from_date').val();
            data.to_date = $('#to_date').val();
        }
    }, 
    createdRow: function (row, data, index) {
        $('td', row).eq(2).addClass('text-capitalize');
    },
});
    $('#btn-search-by-date').click(function () { //button filter event click
        simpletable.ajax.reload(null, false); //just reload table
    });
});