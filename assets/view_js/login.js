$("#login_form").submit(function(e) {
    e.preventDefault();
    var t = $(this);
    $.ajax({
        dataType: "json",
        type: "POST",
        url: t.attr("action"),
        data: t.serialize(),
        beforeSend: function() {
            $('#login_button').button('loading');
        },
        success: function(e) {
            $('#login_button').button('reset');
            "success" == e.status ? window.location.replace(e.url) : error_msg(e.error);
        },
    });
});