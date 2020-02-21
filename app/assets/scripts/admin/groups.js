$(document).ready(function () {
    // reviewed
    $("button#add-group").on("click", function () {
        if ($("input#NewGroupName").val() != "") {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/admin/user_group',
                data: {
                    'name': $("input#NewGroupName").val()
                },
                success: function (response)
                {
                    if (response.value == true)
                    {
                        alert("Group Created.");
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
