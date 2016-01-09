<div id="off-sidebar" class="sidebar">
<div class="sidebar-wrapper">
<ul class="nav nav-tabs nav-justified">
    @if(in_array('create_message',array_values(session('functionArr'))))
    <li>
        <a href="#off-users" aria-controls="off-users" role="tab" data-toggle="modal" data-target="#compose-msg" id="message">
            <i class="ti-comments"></i>Compose Message

        </a>

    </li>
    @else
    <li>
        <a href="#off-users" aria-controls="off-users" role="tab" id="message" onclick="alertError()">
            <i class="ti-comments"></i>Compose Message
        </a>
    </li>
    @endif
</ul>

<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="off-users">
<div id="users" toggleable active-class="chat-open">
<div class="users-list">
    <div class="sidebar-content perfect-scrollbar">
        <ul class="media-list" id="userList">

        </ul>
    </div>
</div>
<div class="user-chat">
<div class="chat-content">
<div class="sidebar-content perfect-scrollbar">
<a class="fixBackButton sidebar-back pull-left " href="#" data-toggle-class="chat-open" data-toggle-target="#users"><i class="ti-angle-left"></i> <span id="backChat">Back</span></a>
<ol class="discussion" id="chat-history">
</ol>
</div>
</div>
    @if(in_array('create_message',array_values(session('functionArr'))))
    <div class="message-bar">
        <div class="message-inner">
            <a class="link icon-only" href="#"><i class="fa fa-camera"></i></a>
            <div class="message-area">
                <textarea placeholder="Message" id="description"></textarea>
            </div>
            <a class="link" id="send-msg" onlick="">
                Send
            </a>
        </div>
    </div>
    @else
    <div class="message-bar">
        <div class="message-inner">
            <a class="link icon-only" href="#"><i class="fa fa-camera"></i></a>
            <div class="message-area">
                <textarea placeholder="Message"  disabled></textarea>
            </div>
            <a class="link"  onclick="alertError()" disabled>
                Send
            </a>
        </div>
    </div>
    @endif
</div>
</div>
</div>
</div>
</div>
</div>
@include('composeMessage')