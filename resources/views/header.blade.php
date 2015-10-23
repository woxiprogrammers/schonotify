<header class="navbar navbar-default navbar-static-top">
    <!-- start: NAVBAR HEADER -->
    <div class="navbar-header">
        <a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
            <i class="ti-align-justify"></i>
        </a>
        <a class="navbar-brand" href="#">
            <!--<img src="assets/images/logo.png" alt="Clip-Two"/>-->
            <h1><span style="color:red;">VE</span>ZA</h1>
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
            <!-- start: MESSAGES DROPDOWN -->
            <li>
                <a href="#">
                    <span class="badge partition-red">12</span> <i class="ti-bell"></i> <span>Notifications</span>
                </a>
            </li>
            <li class="dropdown">
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <span class="badge partition-red">22</span> <i class="ti-comment"></i> <span>MESSAGES</span>
                </a>
                <ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large">
                    <li>
                        <span class="dropdown-header"> Unread messages</span>
                    </li>
                    <li>
                        <div class="drop-down-wrapper ps-container flexcroll">
                            <ul>
                                <li class="unread">
                                    <a href="javascript:;" class="unread" data-toggle-class="app-offsidebar-open chat-open" data-toggle-target="#app,#users" data-toggle-click-outside="#off-sidebar">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <img src="./assets/images/avatar-2.jpg" alt="">
                                            </div>
                                            <div class="thread-content">
                                                <span class="author">Mrs.Rossy Sharma</span>
                                                <span class="preview">document verifications completed waiting for admission...</span>
                                                <span class="time"> Just Now</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="unread" data-toggle-class="app-offsidebar-open chat-open" data-toggle-target="#app,#users" data-toggle-click-outside="#off-sidebar">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <img src="./assets/images/avatar-3.jpg" alt="">
                                            </div>
                                            <div class="thread-content">
                                                <span class="author">Mr.Vishnu Nimangare</span>
                                                <span class="preview">then i will be there at meeting ...</span>
                                                <span class="time">8 hrs</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="unread" data-toggle-class="app-offsidebar-open chat-open" data-toggle-target="#app,#users" data-toggle-click-outside="#off-sidebar">
                                        <div class="clearfix">
                                            <div class="thread-image">
                                                <img src="./assets/images/avatar-5.jpg" alt="">
                                            </div>
                                            <div class="thread-content">
                                                <span class="author">Mr.Debojit Boss</span>
                                                <span class="preview">fine.. thank you!</span>
                                                <span class="time">14 hrs</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="view-all">
                        <a href="javascript:;" class="unread" data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">
                            See All
                        </a>
                    </li>
                </ul>
            </li>
            <!-- end: MESSAGES DROPDOWN -->

            <!-- start: USER OPTIONS DROPDOWN -->
            <li class="dropdown current-user">
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <img src="assets/images/{!! Auth::user()->image !!}" alt="Peter"> <span class="username">{!! Auth::user()->username !!}</span><i class="ti-angle-down"></i></i></span>
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
                        <a href="logout">
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
    <a class="dropdown-off-sidebar" data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">
        &nbsp;
    </a>
    <!-- end: NAVBAR COLLAPSE -->
</header>