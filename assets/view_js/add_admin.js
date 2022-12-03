$(document).ready(function() {
    load_admin_data();
});

function load_admin_data() {
    var dataTable = $('#role_data_table').DataTable({
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