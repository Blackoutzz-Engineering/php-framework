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
});