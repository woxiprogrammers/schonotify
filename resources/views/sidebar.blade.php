
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

        <li>
            <a href="/searchUsers">
                <span class="title"> Users </span>
            </a>
        </li>


        <li>
            <a href="/searchClasses/2">
                <span class="title"> Classes  </span>
            </a>
        </li>

        <li>
            <a href="/searchSubjects">
                <span class="title"> Subjects  </span>
            </a>
        </li>

    </ul>

</li>

<li>
    <a href="/createUsers/1">
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

<li>
    <a href="javascript:void(0)">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-pencil-square-o"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Create Class </span><i class="icon-arrow"></i>
            </div>
        </div>
    </a>
    <ul class="sub-menu">

        <li>
            <a href="/create-class">
                <div class="item-inner">
                    <span class="title"> Create Class </span>
                </div>
            </a>
        </li>
        <li>
            <a href="/create-division">
                <div class="item-inner">
                    <span class="title"> Create Division </span>
                </div>
            </a>
        </li>

    </ul>
</li>

<li>
    <a href="javascript:void(0)">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-pencil-square-o"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Create Subject </span><i class="icon-arrow"></i>
            </div>
        </div>
    </a>
    <ul class="sub-menu">

        <li>
            <a href="/create-subject">
                <div class="item-inner">
                    <span class="title"> Create Subject </span>
                </div>
            </a>
        </li>
        <li>
            <a href="/subject-teacher">
                <div class="item-inner">
                    <span class="title"> Assign Subjects </span>
                </div>
            </a>
        </li>

    </ul>
</li>

<li>
    <a href="/timetable">
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
    <a href="/event/1">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-calendar-o"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Events </span>
            </div>
        </div>
    </a>
</li>

<!--<li>
    <a href="/noticeBoard">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-bullhorn"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Notice Board </span>
            </div>
        </div>
    </a>
</li>-->
<li>
    <a href="javascript:void(0)">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-pencil-square-o"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Attendance </span><i class="icon-arrow"></i>
            </div>
        </div>
    </a>
    <ul class="sub-menu">
        <li id="markAttendanceCheck">
            <a href="/mark-attendance">
                <span class="title"> Mark Attendance </span>
            </a>
        </li>
        <li>
            <a href="/view-attendance">
                <span class="title"> View Attendance  </span>
            </a>
        </li>
        <li id="leaveCheck">
            <a href="/leaveListing">
                <span class="title" > Leaves </span>
                @if(Auth::User()->role_id != 1)
                <span class="badge pull-right" id="leaveCount"></span>
                @endif
            </a>
        </li>
    </ul>
</li>
@if(Auth::User()->role_id != 1)
<li>
    <a href="/homework-listing">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-book"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Homework </span>
            </div>
        </div>
    </a>
</li>
@endif
<!--<li>
    <a href="/results">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-bar-chart"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Results </span>
            </div>
        </div>
    </a>
</li>-->
<!--<li>
    <a href="javascript:void(0)">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-history"></i>
            </div>
            <div class="item-inner">
                <span class="title"> Students History </span><i class="icon-arrow"></i>
            </div>
        </div>
    </a>
    <ul class="sub-menu">
        <li>
            <a href="/students-attendance-history">
                <span class="title"> Attendance </span>
            </a>
        </li>

        <li>
            <a href="/students-results-history">
                <span class="title"> Results  </span>
            </a>
        </li>

        <li>
            <a href="#">
                <span class="title"> Fees </span>
            </a>
        </li>
    </ul>
</li>-->
@if(Auth::User()->role_id == 1)

<li>
    <a href="javascript:void(0)">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-handshake-o"></i>
            </div>
            <div class="item-inner">
                <span class="title">Admission Enquiry Form </span><i class="icon-arrow"></i>
            </div>
        </div>
    </a>
    <ul class="sub-menu">

        <li>
            <a href="/student-enquiry">
                <div class="item-inner">
                    <span class="title"> Enquiry Form </span>
                </div>
            </a>
        </li>
        <li>
            <a href="/manage">
                <div class="item-inner">
                    <span class="title"> Enquiry Listing </span>
                </div>
            </a>
        </li>
    </ul>
</li>

@endif
<li>
    <a href="javascript:void(0)">
        <div class="item-content">
            <div class="item-media">
                <i class="fa fa-money"></i>
            </div>
            <div class="item-inner">
                <span class="title">Fees </span><i class="icon-arrow"></i>
            </div>
        </div>
    </a>
    <ul class="sub-menu">

        <li>
            <a href="/fees/create">
                <div class="item-inner">
                    <span class="title"> Create Structure </span>
                </div>
            </a>
        </li>

        <li>
            <a href="/fees/feelisting">
                <div class="item-inner">
                    <span class="title"> fee structure listing </span>
                </div>
            </a>
        </li>

    </ul>
</li>
</ul>
</nav>
</div>
</div>
<!-- / sidebar -->
