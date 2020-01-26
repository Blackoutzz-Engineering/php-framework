function reset_button()
{
    $("button.toggle").off("click");
    page_ready();
}

function page_ready() {

    $("button.toggle#install").on("click", function () {
        var slug = $(this).attr("name");
        var button = $(this);
        $(this).attr("id", "installing");
        $.ajax({
            url: '/ajax/admin/plugins/install/'+slug+'/',
            type: 'POST',
            data: { 'validation_nonce': user_nonce, 'slug': slug  },
            success: function (result) {
                if (result) {
                    $("div#plugins-callback").removeClass("hidden");
                    $("div#plugins-callback").removeClass("danger");
                    $("div#plugins-callback").removeClass("warning");
                    $("div#plugins-callback").addClass("success");
                    button.children("svg").attr("data-icon", "toggle-on");
                    $("div.alert#plugins-callback").html("Installed " + slug + " successfully! " + icons.check);
                    button.attr("id", "uninstall");
                    reload_menu();
                } else {
                    $("div#plugins-callback").removeClass("hidden");
                    $("div#plugins-callback").removeClass("success");
                    $("div#plugins-callback").removeClass("warning");
                    $("div#plugins-callback").addClass("danger");
                    $("div#plugins-callback").html("Unable to install " + slug + " " + icons.refreshing);
                    button.attr("id", "install");
                }
                reset_button();  
            }
        });
    });

    $("button.toggle#uninstall").on("click", function () {
        var slug = $(this).attr("name");
        var button = $(this);
        $(this).attr("id", "uninstalling");
        $.ajax({
            url: '/ajax/admin/plugins/uninstall/' + slug + '/',
            type: 'POST',
            data: { 'validation_nonce': user_nonce, 'slug': slug },
            success: function (result) {
                if (result) {
                    $("div#plugins-callback").removeClass("hidden");
                    $("div#plugins-callback").removeClass("danger");
                    $("div#plugins-callback").removeClass("warning");
                    $("div#plugins-callback").addClass("success");
                    button.children("svg").attr("data-icon", "toggle-off");
                    $("div.alert#plugins-callback").html("Uninstalled " + slug + " successfully! " + icons.check);
                    button.attr("id", "install");
                    reload_menu();
                } else {
                    $("div#plugins-callback").removeClass("hidden");
                    $("div#plugins-callback").removeClass("success");
                    $("div#plugins-callback").removeClass("warning");
                    $("div#plugins-callback").addClass("danger");
                    $("div#plugins-callback").html("Unable to uninstall " + slug + " " + icons.refreshing);
                    button.attr("id", "uninstall");
                }
                reset_button();  
            }
        });
    });
}

