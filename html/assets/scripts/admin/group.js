﻿$(document).ready(function () {

    $("button#add-permission").on("click", function () {
        if ($("select#NewGroupPermission").val() != "") {
            $.ajax({
                url: '/ajax/admin/user_group_permission',
                type: 'POST',
                dataType: 'json',
                data: {
                    'group': $("input#group-id").val(),
                    'permission': $("select#NewGroupPermission").val()
                },
                success: function (response)
                {
                    if (response.value == true)
                    {
                        alert("New group permission Created.");
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
        if ($("select#NewGroupOption").val() != "" && $("input#NewGroupOptionValue").val() != "") {
            $.ajax({
                url: '/ajax/admin/user_group_option',
                type: 'POST',
                dataType: 'json',
                data: {
                    'group': $("input#group-id").val(),
                    'option': $("select#NewGroupOption").val(),
                    'value': $("input#NewGroupOptionValue").val()
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
        if ($("select#NewGroupPage").val() != "") {
            $.ajax({
                url: '/ajax/admin/user_group_controller_view',
                type: 'POST',
                dataType: 'json',
                data:{
                    'group': $("input#group-id").val(),
                    'page': $("select#NewGroupPage").val()
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

    $("i[name='user_group_controller_view']").on("click", function () {
        var id = $(this).attr("id");
        var button = $(this);
        var status = button.hasClass("fa-toggle-on");
        $.ajax({
            url: '/ajax/admin/user_group_controller_view/'+id,
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
    
    $("i[name='user_group_permission']").on("click", function () {
        var id = $(this).attr("id");
        var button = $(this);
        var status = button.hasClass("fa-toggle-on");
        $.ajax({
            url: '/ajax/admin/user_group_permission/'+id,
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