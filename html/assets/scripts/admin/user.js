$(document).ready(function () {

    $("button#add-permission").on("click", function () {
        if ($("select#NewUserPermission").val() != "") {
            $.ajax({
                url: '/ajax/admin/user_permission',
                type: 'POST',
                dataType: 'json',
                data: {
                    'user': $("input#user-id").val(),
                    'permission': $("select#NewUserPermission").val()
                },
                success: function (response)
                {
                    if (response.value == true)
                    {
                        alert("New user permission Created.");
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

    $("button#add-option").on("click", function () {
        if ($("select#NewUserOption").val() != "" && $("input#NewUserOptionValue").val() != "") {
            $.ajax({
                url: '/ajax/admin/user_option',
                type: 'POST',
                dataType: 'json',
                data: {
                    'user': $("input#user-id").val(),
                    'option': $("select#NewUserOption").val(),
                    'value': $("input#NewUserOptionValue").val()
                },
                success: function (response)
                {
                    if (response.value == true)
                    {
                        alert("New option Created.");
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

    $("button#add-page").on("click", function () {
        if ($("select#NewUserPage").val() != "") {
            $.ajax({
                url: '/ajax/admin/user_controller_view',
                type: 'POST',
                dataType: 'json',
                data:
                {
                    'user': $("input#user-id").val(),
                    'page': $("select#NewUserPage").val()
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

    $("i[name='user_controller_view']").on("click", function () {
        var id = $(this).attr("id");
        var button = $(this);
        var status = button.hasClass("fa-toggle-on");
        $.ajax({
            url: '/ajax/admin/user_controller_view/'+id,
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
                    console.log("toggle-page issue");
                }
            }
        });
    });
    
    $("i[name='user_permission']").on("click", function () {
        var id = $(this).attr("id");
        var button = $(this);
        var status = button.hasClass("fa-toggle-on");
        $.ajax({
            url: '/ajax/admin/user_permission/'+id,
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