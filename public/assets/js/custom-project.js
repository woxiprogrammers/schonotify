

function getMsgCount() {
    $.get('/get-msg-count',function(res){
        if(res == 0){
            $('#msgCount').html('');
        }else{
            $('#msgCount').html(res);
        }
    });
}
function doListing(id) {
    var route='/get-detail-message/'+id;
    $.get(route,function(res){
        var str="";
        for(var i=0; i<res.length; i++)
        {
            if(res[i]['from_id'] == id){
                str+='<li class="self">'+
                    '<input type="hidden" name="to_id" id="to_id" value="'+ id +'" />'+
                    '<div class="message">'+
                    '<div class="message-wrap message-text">'+res[i]['description']+'<div class="messages-date new-date">'+res[i]['date'] +'</div>'+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }else{
                str+='<li class="other">'+
                    '<div class="message">'+
                    '<div class="message-wrap message-text">'+res[i]['description']+'<div class="messages-date new-date">'+res[i]['date'] +'</div>'+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }
        }

        $('#chat-history').html(str);
        $(".perfect-scrollbar").scrollTop( $( '#chat-history').prop( "scrollHeight" ) );
        $(".perfect-scrollbar").perfectScrollbar('update');
        getMsgCount();
        toggle();
    });
}
$('#send-msg').hide();

$('#description').on('keyup',function(){
    console.log($('#description').val());
    if($('#description').val()==" " || $('#description').val()==""){
        $('#send-msg').hide();
    }else{
        if($('#description').val().trim() == ""){

            $('#send-msg').hide();
        }else{

            $('#send-msg').show();
        }
    }
});

$('#send-msg').click(function() {
    var val = $('#chat-history').find('input[type=hidden]:first').val();
    var description = $('#description').val();

    var route='/send-message';
    $.post(route,{id:val,description:description},function(res){
        var str="";
        for(var i=0; i<res.length; i++)
        {
            if(res[i]['to_id'] == val){
                str+='<li class="other">'+
                    '<div class="message">'+
                    '<div class="message-wrap message-text">'+res[i]['description']+'<div class="messages-date new-date">'+res[i]['date'] +'</div>'+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }else{
                str+=
                    '<li class="self">'+
                    '<input type="hidden" name="to_id" id="to_id" value="'+ val +'" />'+
                    '<div class="message">'+
                    '<div class="message-wrap message-text">'+res[i]['description']+'<div class="messages-date new-date">'+res[i]['date'] +'</div>'+'</div>'+
                    '<div class="message-avatar"><img src="'+res[i]['from_avatar']+'" alt="">'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            }
        }
        $('#chat-history').html(str);
        $(".perfect-scrollbar").scrollTop( $( '#chat-history').prop( "scrollHeight" ) );
        $(".perfect-scrollbar").perfectScrollbar('update');
        toggle();
        $('#description').val('');
        $('#send-msg').hide();
    });
});

$('#msgCountArea').click(function() {
    $.get('/get-unread-list',function(res){
        var str="";
        for(var i=0; i<res.length; i++) {
            str+='<li><a href="javascript:void(0);" onclick="doListing('+res[i]['user_id']+');" class="unread" data-toggle-class="app-offsidebar-open chat-open" data-toggle-target="#app,#users" data-toggle-click-outside="#off-sidebar" >'+
                '<div class="clearfix">'+
                '<div class="thread-image">'+
                '<img class ="message_image" src= "'+res[i]["avatar"]+'" alt="">'+
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
        if(str == ""){
            var noData="No new message found.";
        $('#msgList').html(noData.bold().italics());
        }else{
        $('#msgList').html(str);
        }
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
        ' You currently do not have permission to access this functionality. Please contact administrator to grant you access'+
        '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
            '<span area-hidden="true">&times;</span>'+
        '</button>'+
    '</div>';
    $('#message-error-div').html(str);

}


////////////Compose Message JS Start///////////

$("#message").click(function() {
    var route='get-user-roles';
    $.get(route,function(res){
    var str = "<option value=''>Please Select User Role</option>";
    for(var i=0; i<res.length; i++){
    str+='<option value='+res[i]['id']+'>'+res[i]['name']+'</option>';
    }
$('#user-role').html(str);
});
$("#compose-message-teacher").hide();
$("#compose-message-admin").hide();
$("#compose-message-student").hide();
});

$("#user-role").change(function() {
    if ( this.value == '1') {
        $("#compose-message-teacher").hide();
        $("#compose-message-admin").show();
        $("#compose-message-student").hide();
    var route='get-admins';
    $.get(route,function(res){
    var str = "<option value=''>Please Select Admin</option>";
    for(var i=0; i<res.length; i++){
    str+='<option value='+res[i]['id']+'>'+res[i]['name']+'</option>';
    }
    $('#admin-list').html(str);
});
}
else if ( this.value == '2')
        {
            $("#compose-message-teacher").show();
            $("#compose-message-admin").hide();
            $("#compose-message-student").hide();
            var route='get-teachers';
            $.get(route,function(res){
            var str = "<option value=''>Please Select Teacher</option>";
            for(var i=0; i<res.length; i++){
            str+='<option value='+res[i]['id']+'>'+res[i]['name']+'</option>';
            }
            $('#teacher-list').html(str);
});
}
else if ( this.value == '3')
        {
            $("#compose-message-teacher").hide();
            $("#compose-message-admin").hide();
            $("#compose-message-student").show();
        }
    else if ( this.value == '')
    {
        $("#compose-message-teacher").hide();
        $("#compose-message-admin").hide();
        $("#compose-message-student").hide();
    }
});




$("#user-role").change(function() {
    var route='get-batches-teacher';
    $.get(route,function(res){
    var str = "<option value=''>Please Select Batch</option>";
    for(var i=0; i<res.length; i++){
    str+='<option value='+res[i]['id']+'>'+res[i]['name']+'</option>';
    }
$('#msgbatch').html(str);
});
});


$("#msgbatch").change(function() {
    var id = this.value;
    var route='get-classes-teacher/'+id;
    $.get(route,function(res){
    var str = "<option value=''>Please Select Class</option>";
    for(var i=0; i<res.length; i++){
    str+='<option value='+res[i]['id']+'>'+res[i]['class_name']+'</option>';
    }
$('#msgclass').html(str);
});
});

$("#msgclass").change(function() {
    var id = this.value;
    var route='get-divisions-teacher/'+id;
    $.get(route,function(res){
    var str = "<option value=''>Please Select Division</option>";
    for(var i=0; i<res.length; i++){
    str+='<option value='+res[i]['id']+'>'+res[i]['division_name']+'</option>';
    }
$('#msgdivision').html(str);
});
});

$("#msgdivision").change(function() {
    var id = this.value;
    var route='get-students/'+id;
    $.get(route,function(res){
    var str = "<option value=''>Please Select Student</option>";
    for(var i=0; i<res.length; i++){
    str+='<option value='+res[i]['id']+'>'+res[i]['name']+'</option>';
    }
$('#student-list').html(str);
});
});



/////Compose Message JS End////////////////////

//////registration js/////////////////
$('#userName').on('keyup',function(){
    var username = $(this).val();
    var route='check-user';
    $.post(route,{name:username},function(res){
        if(res == 0 ) {
            $('#feedback').removeClass("alert alert-danger ");
            $('#feedback').addClass("alert alert-success ");
            $('#feedback').html("Username Can Be Used");
            $('#checkUser').removeAttr('disabled');
        } else {
            $('#feedback').addClass("alert alert-danger ");
            $('#feedback').html("Username Already Exists");
            $('#checkUser').attr('disabled','disabled');
        }
    });
});

$('#email').on('keyup',function(){
    var email = $(this).val();
    if(email.length == 0){
        $('#emailfeedback').addClass("alert alert-danger alert-dismissible");
        $('#emailfeedback').html("Email Id Already Exists");
        $('#checkUser').attr('disabled','disabled');
    }else{
    var route='check-email';
    $.post(route,{email:email},function(res){
        if(res == 0 ) {
            $('#emailfeedback').removeClass("alert alert-danger alert-dismissible");
            $('#emailfeedback').addClass("alert alert-success alert-dismissible");
            $('#emailfeedback').html("Email Id Can Be Used");
            $('#checkUser').removeAttr('disabled');
        } else {
            $('#emailfeedback').addClass("alert alert-danger alert-dismissible");
            $('#emailfeedback').html("Email Id Already Exists");
            $('#checkUser').attr('disabled','disabled');
        }
    });
    }
});

$('#stud_email').on('keyup',function(){
    var email = $(this).val();
    if(email.length == 0){
        $('#checkUser').removeAttr('disabled');
    }else{
        var route='check-email';
        $.post(route,{email:email},function(res){
            if(res == 0 ) {
                $('#emailfeedback').removeClass("alert alert-danger alert-dismissible");
                $('#emailfeedback').addClass("alert alert-success alert-dismissible");
                $('#emailfeedback').html("Email Id Can Be Used");
                $('#checkUser').removeAttr('disabled');
            } else {
                $('#emailfeedback').addClass("alert alert-danger alert-dismissible");
                $('#emailfeedback').html("Email Id Already Exists");
                $('#checkUser').attr('disabled','disabled');
            }
        });
    }
});

$('#editEmail').on('keyup',function(){
    var email = $(this).val();
    var userId = $("#userId").val();
    if(email.length == 0){
        $('#updateUserInfo').removeAttr('disabled');
    }else{
    var route='/check-email-edit';
    $.post(route,{email:email,userId:userId},function(res){
        if(res == 0 ) {
            $('#emailfeedback').removeClass("alert alert-danger alert-dismissible");
            $('#emailfeedback').addClass("alert alert-success alert-dismissible");
            $('#emailfeedback').html("Email Id Can Be Used");
            $('#updateUserInfo').removeAttr('disabled');
        } else if(res == 1) {
            $('#emailfeedback').addClass("alert alert-danger alert-dismissible");
            $('#emailfeedback').html("Email Id Already Exists");
            $('#updateUserInfo').attr('disabled','disabled');
        }else if(res == 2 ){
            $('#emailfeedback').removeClass("alert alert-danger alert-dismissible");
            $('#emailfeedback').html("");
            $('#updateUserInfo').removeAttr('disabled');
        }
    });
    }
});

$('#editEmailParent').on('keyup',function(){
    var email = $(this).val();
    var userId = $("#userPerentId").val();
    if(email.length == 0){
        $('#updateUserInfo').removeAttr('disabled');
    }else{
    var route='/check-email-edit';
    $.post(route,{email:email,userId:userId},function(res){
        if(res == 0 ) {
            $('#emailparentfeedback').removeClass("alert alert-danger alert-dismissible");
            $('#emailparentfeedback').addClass("alert alert-success alert-dismissible");
            $('#emailparentfeedback').html("Email Id Can Be Used");
            $('#updateUserInfo').removeAttr('disabled');
        } else if(res == 1) {
            $('#emailparentfeedback').addClass("alert alert-danger alert-dismissible");
            $('#emailparentfeedback').html("Email Id Already Exists");
            $('#updateUserInfo').attr('disabled','disabled');
        }else if(res == 2 ){
            $('#emailparentfeedback').removeClass("alert alert-danger alert-dismissible");
            $('#emailparentfeedback').html("");
            $('#updateUserInfo').removeAttr('disabled');
        }
    });
    }
});
//////////registration Js///////
checkMarkAttendanceAccess();
function checkMarkAttendanceAccess()
{
    var route="mark-attendance-check";
    $.get(route,function(res){
        if ( res == 0 ) {
            $('#markAttendanceCheck').hide();
        }
    });
}
