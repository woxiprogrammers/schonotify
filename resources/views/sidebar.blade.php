
<!-- sidebar -->
<div class="sidebar app-aside" id="sidebar">
<div class="sidebar-container perfect-scrollbar">
<nav>

<ul class="main-navigation-menu">
<li class="active open">
    <a href="/">
        <div class="item-content">
            <div class="item-media">
                <i class="ti-home"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Dashboard </span>
            </div>
        </div>
    </a>
</li>

<li>
    <a href="javascript:void(0)">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-search"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Search </span><i class="icon-arrow"></i>
            </div>
        </div>
    </a>
    <ul class="sub-menu">
        @foreach(session('functionArr') as $row)
        @if($row == 'view_user')
        <li>
            <a href="searchUsers">
                <span class="title"> Users </span>
            </a>
        </li>
        @endif
        @if($row == 'view_class')
        <li>
            <a href="searchClasses/2">
                <span class="title"> Classes  </span>
            </a>
        </li>
        @endif

        @endforeach
    </ul>

</li>

    @foreach(session('functionArr') as $row)
    @if($row == 'create_user')
    <li>
        <a href="createUsers/1">
            <div class="item-content">
                <div class="item-media">
                    <i class="fa fa-users"></i>
                </div>
                <div class="item-inner">
                    <span class="title"> Create Users </span>
                </div>
            </div>
        </a>
    </li>
    @endif
    @endforeach

    @foreach(session('functionArr') as $row)
    @if($row == 'create_class')
    <li>
    <a href="createClass">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-suitcase"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Create Class </span>
            </div>
        </div>
    </a>
    </li>
    @endif
    @endforeach

    @foreach(session('functionArr') as $row)
    @if($row == 'create_division')
    <li>
        <a href="javascript:void(0);">
            <div class="item-content">
                <div class="item-media">
                    <i class="fa fa-th-list"></i>
                </div>
                <div class="item-inner">
                    <span class="title"> Create Division </span>
                </div>
            </div>
        </a>
    </li>
    @endif
    @endforeach

    <li>
        <a href="timetable">
            <div class="item-content">
                <div class="item-media">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="item-inner">
                    <span class="title"> Timetable </span>
                </div>
            </div>
        </a>
    </li>
    <li>
        <a href="event">
            <div class="item-content">
                <div class="item-media">
                    <i class="fa fa-calendar-o"></i>
                </div>
                <div class="item-inner">
                    <span class="title"> Events </span>
                    <span class="badge pull-right">12</span>
                </div>
            </div>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <div class="item-content">
                <div class="item-media">
                    <i class="fa fa-bullhorn"></i>
                </div>
                <div class="item-inner">
                    <span class="title"> Notifications </span>
                    <span class="badge pull-right">9</span>
                </div>
            </div>
        </a>
    </li>
</ul>
</nav>
</div>
</div>
<!-- / sidebar -->
