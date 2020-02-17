$(document).ready(function () {
    // reviewed
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
    // reviewed
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
    // ask mick wtf is a group_page
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
});