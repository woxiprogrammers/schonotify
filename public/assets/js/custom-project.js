
function getMsgCount() {
    $.get('/get-msg-count',function(res){
        $('#msgCount').html(res);
    });
}
function doListing(id) {
    var route='/get-detail-message/'+id;
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
        toggle();
    });
}

$('#send-msg').click(function() {
    var val=$('#to_id').val();
    var description = $('#description').val();
    var route='/send-message';
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
        toggle();
        $('#description').val('');
    });
});

$('#msgCountArea').click(function() {
    $.get('/get-unread-list',function(res){
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

        var seeAll='<a href="javascript:;" class="unread" data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">See All</a>';
        $('#see-all').html(seeAll);
        $('#msgList').html(str);
        toggle();
    });
});

$('#see-all').click(function(){
    userList();
});

$('#backChat').click(function(){
    $("#users").removeClass("chat-open");
    userList();
})

function userList(){
    $.get('/get-msg-list',function(res){
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
        toggle();
    });
}

function toggle(){
    var toggleAttribute = $('*[data-toggle-class]');
    toggleAttribute.each(function() {
        var _this = $(this);
        var toggleClass = _this.attr('data-toggle-class');
        var outsideElement;
        var toggleElement;
        typeof _this.attr('data-toggle-target') !== 'undefined' ? toggleElement = $(_this.attr('data-toggle-target')) : toggleElement = _this;
        _this.on("click", function(e) {
            if(_this.attr('data-toggle-type') !== 'undefined' && _this.attr('data-toggle-type') == "on") {
                toggleElement.addClass(toggleClass);
            } else if(_this.attr('data-toggle-type') !== 'undefined' && _this.attr('data-toggle-type') == "off") {
                toggleElement.removeClass(toggleClass);
            } else {
                toggleElement.toggleClass(toggleClass);
            }
            e.preventDefault();
            if(_this.attr('data-toggle-click-outside')) {

                outsideElement = $(_this.attr('data-toggle-click-outside'));
                $(document).on("mousedown touchstart", toggleOutside);

            };

        });

        var toggleOutside = function(e) {
            if(outsideElement.has(e.target).length === 0//checks if descendants of $box was clicked
                && !outsideElement.is(e.target)//checks if the $box itself was clicked
                && !toggleAttribute.is(e.target) && toggleElement.hasClass(toggleClass)) {

                toggleElement.removeClass(toggleClass);
                $(document).off("mousedown touchstart", toggleOutside);
            }
        };

    });
}

function alertError()
{
    var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
        ' You currently do not have view access to your messages. Please contact administrator to grant you access'+
        '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
            '<span area-hidden="true">&times;</span>'+
        '</button>'+
    '</div>';
    $('#message-error-div').html(str);

}