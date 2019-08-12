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
            {{--COMMENT NOTIFICATION FOR MAE--}}
            {{--<li class="dropdown">
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <span class="badge partition-red">0</span> <i class="ti-bell"></i> <span>Notifications</span>
                </a>
                <ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large">
                    <li>
                        <span class="dropdown-header"></span>
                    </li>
                    <li>
                        <div class="drop-down-wrapper ps-container flexcroll">
                            <ul>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>--}}
            {{--end COMMENT NOTIFICATION FOR MAE--}}
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
                    <img class ="profile-image-new" src="/uploads/profile-picture/{!! $user->avatar !!}" > <span class="username">{!! $user->username !!}</span><i class="ti-angle-down"></i></i></span>
                </a>
                <ul class="dropdown-menu dropdown-dark">
                    <li>
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
