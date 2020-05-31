@include('admin.header')
@include('admin.navbar')
@include('admin.leftside')



<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content" style="margin-right: 35px">

        @if(Session::has('message'))

            <div class="alert alert-success">

                {{Session::get('message')}}
                {{Session::forget('message')}}

            </div>

        @endif
        @yield('content')
    </div> <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    2016 - 2019 &copy; Adminto theme by <a href="">Coderthemes</a>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right footer-links d-none d-sm-block">
                        <a href="javascript:void(0);">About Us</a>
                        <a href="javascript:void(0);">Help</a>
                        <a href="javascript:void(0);">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

@include('admin.rightside')

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

@include('admin.footer')