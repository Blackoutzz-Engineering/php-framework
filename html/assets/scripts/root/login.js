$(document).ready(function () {
    console.log("session handling : ready");
    $("a#login").off().on('click', function () {
        console.log("session handling : init");
        var email = $("input#email").val();
        var password = $("input#password").val();
        if (email != "" && password != "") {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/login/',
                data: {
                    'email': email,
                    'password': password
                },
                success: function (response) {
                    console.log("response back");
                    if (response.value == true) {
                        location.href = "/dashboard";
                        location.reload();
                    } else {
                        alert(response.value);
                    }
                }
            });
        }
    });
});