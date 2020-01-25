//database related call
function get_bot(pname) {
    console.log("AJAX : loading bot.");
    $.ajax({
        type: 'POST',
        url: '/ajax/admin/bot/initialize/',
        data: { validation_nonce: user_nonce, bot: bot },
        success: function (data) {
            if (handle_ajax(data)) {
                console.log(bot+" initialized successfully.");
                location.reload(true);
            } else {
                console.log("Initialize Error.");
            }
        }
    });
}

function initialize_bot() {
    var bot = $("button#initialize").attr("name");
    console.log("AJAX : Initialize @"+bot+" bot.");
    $.ajax({
        type: 'POST',
        url: '/ajax/cloudproxy/tests/get/',
        data: { validation_nonce: user_nonce },
        success: function (data) {
            console.log("Trying to get cloudproxy tests.");
            if (handle_ajax(data)) {
                console.log("Cloudproxy tests loaded successfully.");
                $("div#cloudproxy-test-list").html(data);
            } else {
                console.log("Get tests error.");
            }
        }
    });
}

function content_ready() {
    $("button#submit-new-test").off().on('click', function () {
        var test_name = $("input#new-test-name").val();
        var test_type = $("select#new-test-type").val();
        if ((test_type >= 1 && test_type != undefined)
            && (test_name != "" && test_name != undefined)) {
            $.ajax({
                type: 'POST',
                url: '/ajax/cloudproxy/tests/add/',
                data: { 'validation_nonce': user_nonce, 'name': test_name, 'type': test_type },
                success: function (data) {
                    console.log("Trying to add new cloudproxy test.");
                    if (handle_ajax(data)) {
                        console.log("New test added successfully.");
                        $("input#new-test-name").val("");
                        get_xss_tests();
                        $('div.modal#form').modal('close');
                    } else {
                        console.log("New test error.");
                    }
                }
            });
        }

    });
    $("button#form").off().on('click', function () {
        console.log("Opening the form");
        $('div.modal#form').modal('show');
    });
    //$("textarea[name='signature']").val('curl -s  --url "$SITE" --data ""');
}

function page_ready() {
    content_ready();
}