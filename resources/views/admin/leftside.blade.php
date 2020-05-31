<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('public/admin/images/favicon.ico')}}"
                 alt="Al Badr"
                 title="Al Badr"
                 class="rounded-circle img-thumbnail avatar-lg"></a>
            <div class="dropdown">
                <a href="{{route('dashboard')}}"
                   class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-toggle="dropdown"></a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">الاقسام</li>
                 <li class="treeview">
                  <a href="{{route('section.index')}}">
                    <i class="mdi mdi-theater"></i> <span>الأقسام</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('section.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الأقسام </a></li>
                    <li><a href="{{route('section.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  قسم</a></li>
                  </ul>
                </li>
                
                
                 <li class="treeview">
                  <a href="{{route('codes.index')}}">
                    <i class="mdi mdi-theater"></i> <span>الاكواد الوظيفية</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('codes.index')}}"><i class="mdi mdi-eye"></i>
                        كل الاكواد الوظيفية </a></li>
                    <li><a href="{{route('codes.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  كود وظيفي </a></li>
                  </ul>
                </li>
                
                <li>
                    <a href="{{ route('admin.users')  }}">
                        <i class="mdi mdi-theater"></i>
                        <span> المشرفين </span>
                    </a>
                </li>

                 <li class="treeview">
                  <a href="{{route('users.index')}}">
                    <i class="mdi mdi-theater"></i> <span>الموظفين</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('users.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الموظفين </a></li>
                    <li><a href="{{route('users.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  موظف</a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="{{route('occasions.index')}}">
                    <i class="mdi mdi-theater"></i> <span>المناسبات</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('occasions.index')}}"><i class="mdi mdi-eye"></i>
                        كل  المناسبات </a></li>
                    <li><a href="{{route('occasions.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  مناسبة</a></li>
                  </ul>
                </li>
                 <li>
                    <a href="{{route('settings.create')}}">
                        <i class="mdi mdi-theater"></i>
                        <span> الاعدادت </span>
                    </a>
                </li>
                

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->