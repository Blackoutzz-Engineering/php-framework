function get_pages(){
    get_box_footer("#pages").html("Loading in progress.");
    var started = $.now();
    $.ajax({
            type: 'POST',
            url: '/ajax/admin/pages/',
            data: { validation_nonce:user_nonce },
            success: function(result){
                if(get_box_body("#pages").html() != result){
                    get_box_body("#pages").html(result);
                }
                get_box_footer("#pages").html("Loaded in "+Math.abs((started - $.now())/1000).toFixed(1) +" seconds.");
            } 
    });
}
//Events
$(document).on('ready',function(){
    get_pages();
    get_box_tools("#pages").children("button.btn-box-tool[data-widget='refresh']").off().on('click',function(){
        if(get_box_footer("#pages").html() != "Loading in progress."){ 
            get_pages();
        }
    });
});