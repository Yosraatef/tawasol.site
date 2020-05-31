<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">


            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect"
                   data-toggle="dropdown" href="#"
                   role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('public/admin/images/users/user-1.jpg')}}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                                <i class="mdi mdi-chevron-down"></i>
                            </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{auth()->guard('admin')->check() ? auth()->guard('admin')->user()->name : 'حساب'}}</h6>
                    </div>


                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <!-- item-->
                    <a href="{{route('admin.logout')}}"
                       class="dropdown-item notify-item"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();" >
                        <i class="fe-log-out"></i>
                        <span>تسجيل الخروج</span>

                    </a>

                    <form id="logout-form" action="{{route('admin.logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
            </li>




        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{route('dashboard')}}" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{{asset('admin/images/logo-dark.png')}}" alt="" height="16">
                            <!-- <span class="logo-lg-text-light">Xeria</span> -->
                        </span>
                <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">X</span> -->
                            <img src="{{asset('admin/images/logo-sm.png')}}" alt="" height="24">
                        </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile disable-btn waves-effect">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <h4 class="page-title-main">لوحة التحكم</h4>
            </li>

        </ul>
    </div>
    <!-- end Topbar -->