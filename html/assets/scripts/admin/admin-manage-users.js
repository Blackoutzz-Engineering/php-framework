function add_user(name,mail,groupid){
        $.ajax({ 
                url: '/ajax/admin/add_user', 
                type: 'POST' , 
                data: {
                    user_nonce:nonce , 
                    username:name , 
                    email:mail ,  
                    group:groupid 
                },
                success: function (result) { 
                if(result == 1){
                    $("div#manager_add_result").html("<p><div class='alert alert-success'><strong>Success : </strong> Credentials have been send by mail.  </div><p>");
                }
                else{
                    $("div#manager_add_result").html("<p><div class='alert alert-danger'><strong>Database Error : </strong> Fix the database. </div></p>");
                }
            } 
        });
}
function mod_user(name,mail,groupid){
    var action = "mod_geek_user";
    $.ajax({ 
            url: 'index.php?page=admin-manage-users', 
            type: 'POST', 
            data: {
                validation_nonce:nonce , 
                ajax_action:action , 
                secret_action:secret , 
                username:name , 
                email:mail ,  
                group:groupid 
            },
            success: function (result) { 
                if(result == 1){
                    $("div#manager_add_result").html("<p><div class='alert alert-success'><strong>Success : </strong> Saved. </div><p>");
                }else{
                    $("div#manager_add_result").html("<p><div class='alert alert-danger'><strong>Database Error : </strong> Fix the database. </div></p>");
                }    
            } 
    });
}
function ban_user(name,mail,groupid){
    var action = "ban_geek_user";
    $.ajax({ 
        url: 'index.php?page=admin-manage-users', 
        type: 'POST', 
        data: { 
            validation_nonce:nonce , 
            ajax_action:action , 
            secret_action:secret , 
            username:name , 
            email:mail ,  
            group:groupid 
        },
        success: function(result){ 
            if(result == 1){
                $("div#manager_add_result").html("<p><div class='alert alert-success'><strong>Success : </strong> User Banned. </div><p>");
                }else{
                $("div#manager_add_result").html("<p><div class='alert alert-danger'><strong>Database Error : </strong> Fix the database. </div></p>");
                }                   
        } 
    });
}
function verify_user(action){
        var name = $( "input[id='add_username']" ).val();
        var email = $( "input[id='add_email']" ).val();
        var group = parseInt($( "select[id='add_group']" ).val());
        if(name != "" && name.length >= 3 && email.search("@sucuri.net") >= 2 && group >= 1 && group <= 100)
        {
            $( "input[id='add_username']" ).val("");
            $( "input[id='add_email']" ).val("");
            $( "select[id='add_group']" ).val(1);
            name = name.toLowerCase();
            name = name.trim();
            email = email.toLowerCase();
            email = email.trim();
            if(action == 1)
                add_user(name,email,group);
            if(action == 2)
                mod_user(name,email,group);
            if(action == 3)
                ban_user(name,email,group);
            
        }
        else
        {
            $("div[id='manager_add_result']").html("<p><div class='alert alert-warning'><strong>Informations Error : </strong> Your provided credentials were not complete or invalid. </div></p>");   
        }
}