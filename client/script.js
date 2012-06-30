$(document).ready(function() {
    var base_href = 'http://localhost/velikov-chat.phpfogapp.com/';
    $("#login-submit").click(function (e) {
        e.preventDefault();
        var user = $("#user").val(),
            pass = $("#pass").val();

        if (user != '' && pass != '') {
            $.ajax({
                url : base_href + 'user/index',
                type: 'post',
                data: {
                    'user' : user,
                    'pass' : pass
                },
                success : function (data) {
                    console.log(data);
                },
                error : function (error, type) {
                    console.log(error, type);
                }
            });
        }
    });
});