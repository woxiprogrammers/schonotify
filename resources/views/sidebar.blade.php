
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
                <i class="ti-search"></i>
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
            <a href="searchClasses">
                <span class="title"> Classes  </span>
            </a>
        </li>
        @endif
        @if($row == 'view_subject')
        <li>
            <a href="searchSubjects">
                <span class="title"> Subjects </span>
            </a>
        </li>
        @endif
        @endforeach
    </ul>
</li>

</ul>
</nav>
</div>
</div>
<!-- / sidebar -->
