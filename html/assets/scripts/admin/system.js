function get_php(){
    console.log("[Application][Admin][System]->Loading");
    get_box_footer_status("#php").html("Loading Php Configurations...");
    get_box_footer_time("#php").html(icons.loading);
    var started = $.now();
    $.ajax({
            type: 'POST',
            url: '/ajax/admin/informations/php/',
            data: { 
                validation_nonce:user_nonce 
            },
            success: function(result){
                var done = Math.abs((started - $.now())/1000).toFixed(1);
                get_box_body("#php").html(result);
                get_box_footer_status("#php").html("Loaded Php Configurations.");
                get_box_footer_time("#php").html("Completed in "+done+" seconds. "+icons.clock);
                console.log("[Application][Admin][System]->Loaded");
            } 
    });
    return true;
}
function page_ready(){
    get_php();
}