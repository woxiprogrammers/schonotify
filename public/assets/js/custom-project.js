
function getMsgCount() {
    $.get('get-msg-count',function(res){
        $('#msgCount').html(res);
    });
}
function doListing(id) {
    var route='get-detail-message/'+id;
    $.get(route,function(res){
        var str="";
        for(var i=0; i<res.length; i++)
        {
            if(res[i]['from_id'] == id){
                str+='<li class="messages-date">'+res[i]['date'] +'</li>'+
                    '<input type="hidden" name="to_id" id="to_id" value="'+ id +'" />'+
                    '<li class="self">'+
                    '<div class="message">'+
                    '<div class="message-name">'+res[i]['from_name']+'</div>'+
                    '<div class="message-text">'+res[i]['description']+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }else{
                str+='<li class="messages-date">'+res[i]['date'] +'</li>'+
                    '<li class="other">'+
                    '<div class="message">'+
                    '<div class="message-name">'+res[i]['from_name']+'</div>'+
                    '<div class="message-text">'+res[i]['description']+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }
        }
        $('#chat-history').html(str);
        getMsgCount();
        Main.init();
    });
}

$('#send-msg').click(function() {
    var val=$('#to_id').val();
    var description = $('#description').val();
    var route='send-message';
    $.post(route,{id:val,description:description},function(res){
        var str="";
        for(var i=0; i<res.length; i++)
        {
            if(res[i]['to_id'] == val){
                str+='<li class="messages-date">'+res[i]['date'] +'</li>'+
                    '<li class="other">'+
                    '<div class="message">'+
                    '<div class="message-name">'+res[i]['from_name']+'</div>'+
                    '<div class="message-text">'+res[i]['description']+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }else{
                str+='<li class="messages-date">'+res[i]['date'] +'</li>'+
                    '<input type="hidden" name="to_id" id="to_id" value="'+ val +'" />'+
                    '<li class="self">'+
                    '<div class="message">'+
                    '<div class="message-name">'+res[i]['from_name']+'</div>'+
                    '<div class="message-text">'+res[i]['description']+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }
        }
        $('#chat-history').html(str);
        Main.init();
        $('#description').val('');
    });
});

$('#msgCountArea').click(function() {
    $.get('get-unread-list',function(res){
        var str="";
        for(var i=0; i<res.length; i++) {
            str+='<li><a href="javascript:void(0);" onclick="doListing('+res[i]['user_id']+');" class="unread" data-toggle-class="app-offsidebar-open chat-open" data-toggle-target="#app,#users" data-toggle-click-outside="#off-sidebar" >'+
                '<div class="clearfix">'+
                '<div class="thread-image">'+
                '<img src= "'+res[i]["avatar"]+'" alt="">'+
                '</div>'+
                '<div class="thread-content">'+
                '<span class="author">'+res[i]['first_name']+' '+res[i]['last_name']+'</span>'+
                '<span class="preview">'+res[i]['description']+'</span>'+
                '<span class="time">'+res[i]['timestamp']+ ' hrs ago</span>'+
                '</div>'+
                '</div>'+
                '</a>'+
                '</li>';
        }
        $('#msgList').html(str);
        Main.init();
    });
});

$('#see-all').click(function(){
    $.get('get-msg-list',function(res){
        var str="";
        for(var i=0; i<res.length; i++) {
            str+='<li class="media">'+
                '<a data-toggle-class="chat-open" data-toggle-target="#users" href="javascript:void(0);" onclick="doListing('+res[i]["user_id"]+')">'+
                '<input type="hidden" name="to_id" id="to_id" value="'+res[i]["user_id"]+'" />'+
                '<img alt="..." src="'+res[i]["avatar"]+'" class="media-object">'+
                '<div class="media-body">'+
                '<h4 class="media-heading">'+res[i]['first_name']+' '+res[i]['last_name']+'</h4>'+
                '<span> '+res[i]['role']+ ' </span>'+
                '</div>'+
                '</a>'+
                '</li>';
        }
        $('#userList').html(str);
        Main.init();
    });
})

$('#backChat').click(function(){
    $("#users").removeClass("chat-open");
    $.get('get-msg-list',function(res){
        var str="";
        for(var i=0; i<res.length; i++) {
            str+='<li class="media">'+
                '<a data-toggle-class="chat-open" data-toggle-target="#users" href="javascript:void(0);" onclick="doListing('+res[i]["user_id"]+')">'+
                '<input type="hidden" name="to_id" id="to_id" value="'+res[i]["user_id"]+'" />'+
                '<img alt="..." src="'+res[i]["avatar"]+'" class="media-object">'+
                '<div class="media-body">'+
                '<h4 class="media-heading">'+res[i]['first_name']+' '+res[i]['last_name']+'</h4>'+
                '<span> '+res[i]['role']+ ' </span>'+
                '</div>'+
                '</a>'+
                '</li>';
        }
        $('#userList').html(str);
        Main.init();
    });
})