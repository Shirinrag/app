$(document).ready(function() {
    load_users_data();
});

function load_users_data() {
    var dataTable = $('#user_data_table').DataTable({
        dom: 'lBfrtip',
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        // "ajax": {
        //     url: frontend_path + 'admin/display_all_jps_billing_payment_table',
        //     type: "POST"
        // },
    });
}