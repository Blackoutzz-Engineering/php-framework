$(document).ready(function () {
    $("button#add-user").on("click", function () {
        if ($("input#NewUserName").val() != "" && $("input#NewUserEmail").val() != "")
        {
            $.ajax({
                url: '/ajax/admin/user/',
                type: 'POST',
                dataType: 'json',
                data: {
                    'username': $("input#NewUserName").val(),
                    'email': $("input#NewUserEmail").val(),
                    'group': $("select#NewUserGroup").val()
                },
                success: function (response)
                {
                    if (response.value == true)
                    {
                        alert("Invitation sent.");
                        location.reload();
                    }
                    else
                    {
                        alert("Something failed.");
                    }
                }
            });
        }
    });
    $("button#reset").on("click", function(){
        var id_ = $(this).attr("data-id");
        $.ajax({
            url: '/ajax/admin/reset_user_password/',
            type: 'POST',
            dataType: 'json',
            data: {
                'id': id_,
            },
            success: function (response)
            {
                if (response.value == true)
                {
                    alert("Reset alert sent.");
                    location.reload();
                }
                else
                {
                    alert("Something failed.");
                }
            }
        });
    });

});