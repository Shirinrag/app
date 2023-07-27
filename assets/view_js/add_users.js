$(document).ready(function() {
    table = $('#user_data_table').DataTable( {
        "ajax": frontend_path+"superadmin/display_all_user_data",
        "columns": [
            { "data": null},
            { "data": "firstName"},
            { "data": "userName"},                  
            { "data": "email"},
            { "data": "phoneNo"},
            { "data": "car_number"},
            { "data": "isVerified",
                // "className": "change_status",
                render: function(data) {
                    // console.log(data);
                    var data_info=data;
                    if (data_info == '1') {
                        return '<label class="badge badge-success">Verified</label>';
                    }else{
                        return '<label class="badge badge-danger">Not Verified</label>';
                    }
                },
            },
            { "data": "referal_code"},
            { "data": "created_at"},
            
            { "data": "statusdata",
                "className": "change_status",
                render: function(data) {
                    var change_status=data.split(",");
                    if (change_status[0] == 1) {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" checked id="switch'+change_status[1]+'" onclick="change_status('+change_status[0]+','+change_status[1]+');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                    } else {
                        return '<label class="toggle"><input class="toggle-checkbox" type="checkbox" id="switch'+change_status[1]+'" onclick="change_status('+change_status[0]+','+change_status[1]+');"><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
                       
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
                   $('#user_data_table').DataTable().ajax.reload(null,false);

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
