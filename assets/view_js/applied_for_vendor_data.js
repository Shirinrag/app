$(document).ready(function() {
    table = $('#applied_for_vendor_data').DataTable( {
        "ajax": frontend_path+"superadmin/display_all_applied_for_vendor_data",
        "columns": [
            { "data": null},
            { "data": "name"},
            { "data": "address"},                  
            { "data": "landmark"},
            { "data": "apply_type",
                render: function(data) {
                    var data_info=data;
                    if (data_info == '1') {
                        return 'Self';
                    }else{
                        return 'Other';
                    }
                },
            },
            
        ],
        "order": [[ 0, 'desc' ]]       
      });   
      table.on('order.dt search.dt', function() {
          table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
              cell.innerHTML = i + 1;
          });
  
      }).draw();
});


function change_status(status,id){ 
    var status=status;
    if(status==1){
        var user_status=0;
    }
    else{
        var user_status=1;
    }
    var user_id=id;
     //console.log(domain_id);
    $.ajax({
       url: frontend_path+"superadmin/change_user_status",
       type: "POST",
       data:{
        'id':user_id,
        'status':user_status
       },
       dataType: 'json',
        // beforeSend:function(){
        //     document.getElementById('header_loader').style.visibility = "visible";
        // },
       success: function(data) {
           // document.getElementById('header_loader').style.visibility = "hidden";
           // table.ajax.reload(null,false);
                   $('#applied_for_vendor_data').DataTable().ajax.reload(null,false);

            swal({
                title: "success",
                text: data.message,
                icon: "success",
                dangerMode: true,
                timer: 1500
             });
       }
   });    
}
