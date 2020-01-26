$(document).ready(function () {
    // reviewed
    $("button#add-permission").on("click", function () {
        if ($("input#NewPermissionName").val() != "") {
            $.ajax({
                url: '/ajax/admin/permission',
                type: 'POST',
                dataType: 'json',
                data: {
                    'name': $("input#NewPermissionName").val(),
                    'description': $("input#NewPermissionDescription").val()
                },
                success: function (response)
                {
                    if (response.value == true)
                    {
                        alert("New permission Created.");
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
