$(document).ready(function () {
    $("button#add-page").on("click", function () 
    {
        if ($("select#NewPermissionPage").val() != "") {
            $.ajax({
                url: '/ajax/admin/permission_controller_view',
                type: 'POST',
                dataType: 'json',
                data:
                {
                    'permission': $("input#permission-id").val(),
                    'page': $("select#NewPermissionPage").val()
                },
                success: function (response)
                {
                    if (response.value == true)
                    {
                        alert("New page Created.");
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
    
    $("i[name='permission_controller_view']").on("click", function () {
        var id = $(this).attr("id");
        var button = $(this);
        var status = button.hasClass("fa-toggle-on");
        $.ajax({
            url: '/ajax/admin/permission_controller_view/'+id,
            type: 'PUT',
            dataType: 'json',
            data: { 
                'validation_nonce': $("input#user_token").val(), 
                'status': status 
            },
            success: function (response) 
            {
                if (response.value) 
                {
                    if(status)
                    {
                        button.removeClass("fa-toggle-on");
                        button.addClass("fa-toggle-off");
                        button.attr("alt","denied");
                    } else {
                        button.removeClass("fa-toggle-off");
                        button.addClass("fa-toggle-on");
                        button.attr("alt","granted");
                    }
                        
                } else {
                    console.log("toggle-permission issue");
                }
            }
        });
    });

});