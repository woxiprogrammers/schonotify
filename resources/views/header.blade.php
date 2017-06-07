<?php $user=Auth::user() ?>
<header class="navbar navbar-default navbar-static-top">
    <!-- start: NAVBAR HEADER -->
    <div class="navbar-header">
        <a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
            <i class="ti-align-justify"></i>
        </a>
        <a class="navbar-brand" href="#">

            <img src="/assets/images/logo.png" alt="VEZA"/>

        </a>
        <a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
            <i class="ti-align-justify"></i>
        </a>
        <a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="ti-view-grid"></i>
        </a>
    </div>
    <!-- end: NAVBAR HEADER -->
    <!-- start: NAVBAR COLLAPSE -->
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-right">
<!--
            <li class="dropdown">
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <span class="badge partition-red">12</span> <i class="ti-bell"></i> <span>Notifications</span>
                </a>
                <ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large">
                    <li>
                        <span class="dropdown-header"></span>
                    </li>
                    <li>
                        <div class="drop-down-wrapper ps-container flexcroll">
                            <ul>
                                <li class="unread">
                                    <a href="javascript:;">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <h1 class="tmln-h2-homework text-white text-center">H</h1>
                                            </div>
                                            <div class="thread-content col-sm-9 padding-left-0">
                                                <span class="author">Homework have been created for Class Fifth.</span>
                                                <span class="preview"><p>Assignment for class fifth on chapter no. 5 & 6</p>
                                                <p>Due Date:<i> 8 Nov, 2015 </i></p></span>
                                                <span class="time"> Just Now</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <h1 class="tmln-h2-leave text-white text-center">L</h1>
                                            </div>
                                            <div class="thread-content col-sm-9 padding-left-0">
                                                <span class="author">Seek Leave for 2 days</span>
                                                <span class="preview"><p>Applying leave for 2 days ...</p>
                                                <p>Due Date:<i> 2 Nov, 2015 </i></p></span>
                                                <span class="time">8 hrs ago</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-toggle-class="app-offsidebar-open chat-open" data-toggle-target="#app,#users" data-toggle-click-outside="#off-sidebar">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <h1 class="tmln-h2-event text-white text-center">E</h1>
                                            </div>
                                            <div class="thread-content col-sm-9 padding-left-0">
                                                <span class="author">Event Created</span>
                                                <span class="preview"><p>Meeting for annual sport planning.</p>
                                                <p>Due Date:<i> 2 Nov, 2015 </i></p></span>
                                                <span class="time">8 hrs ago</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="view-all">
                        <a href="auto-notification" >
                            See All
                        </a>
                    </li>
                </ul>
            </li>
-->
            @if($user->role_id == 1)
            <li class="dropdown">
            </li>
            @else
            @if(in_array('view_message',session('functionArr')))
            <li class="dropdown">
                <a href class="dropdown-toggle" data-toggle="dropdown" id="msgCountArea">

                    <span id ="msgCount" class="badge partition-red"></span> <i class="ti-comment"></i> <span>MESSAGES</span>
                </a>
                <ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large">
                    <li>
                        <span class="dropdown-header"> Unread messages</span>
                    </li>
                    <li>
                        <div class="drop-down-wrapper ps-container flexcroll">

                            <ul id="msgList">
                            </ul>
                        </div>
                    </li>
                    <li class="view-all" id="see-all">
                        <a href="javascript:;" class="unread" data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">
                            See All
                        </a>
                    </li>
                </ul>
            </li>
            @else
            <li class="dropdown">
                <a id="msgCountArea" onclick="alertError()">
                    <span id ="msgCount" class="badge partition-red"></span> <i class="ti-comment"></i> <span>MESSAGES</span>
                </a>
            </li>
            @endif
            @endif



            <!-- start: USER OPTIONS DROPDOWN -->
            <li class="dropdown current-user">
                <a href class="dropdown-toggle" data-toggle="dropdown">
                <span class="username">{!! $user->username !!}</span><i class="ti-angle-down"></i></i></span>
                </a>
                <ul class="dropdown-menu dropdown-dark">
                    <!--<li>
                        <a href="/myProfile">
                            My Profile
                        </a>
                    </li>
                    <!--<li>
                        <a href="/lockScreen">
                            Lock Screen
                        </a>
                    </li>-->
                    <li>
                        <a href="/logout">
                            Log Out
                        </a>
                    </li>
                </ul>
            </li>
            <!-- end: USER OPTIONS DROPDOWN -->
        </ul>
        <!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
        <div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
            <div class="arrow-left"></div>
            <div class="arrow-right"></div>
        </div>
        <!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
    </div>
    @if($user->role_id == 1)
    <a></a>
    @else
    @if(in_array('view_message',session('functionArr')))
    <a class="dropdown-off-sidebar" data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">
        &nbsp;
    </a>
    @endif
    @endif
    <!-- end: NAVBAR COLLAPSE -->
</header>
