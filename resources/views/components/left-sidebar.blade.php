<div class="left-sidebar">
    <!-- LOGO -->
    <div class="brand">
        <a href="index.html" class="logo">
            <span style="margin: 0">
                <i class="ti ti-letter-r"></i>
            </span>
            <span>
                <img src="assets/images/logo.png" alt="logo-large" class="logo-lg logo-light">
                <div class="logo-lg logo-dark">EMAIN</div>
            </span>
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <div class="menu-body navbar-vertical tab-content">
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="menu-label mt-0"><i class="ti ti-letter-m"></i><span>ain</span></li>
                    <hr>
                    <!-- Menu ini hanya untuk role 'operator' -->
                    @if (Auth::check() && Auth::user()->role === 'operator')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator.dashboard') }}"><i
                                    class="ti ti-home menu-icon"></i><span>Dashboard</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator.akun.index') }}"><i
                                    class="ti ti-user menu-icon"></i><span>Akun
                                    Tim </span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator.pasien.index') }}"><i
                                    class="fas fa-bed menu-icon"></i><span>Pasien</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator.kuisioner.index') }}"><i
                                    class="ti ti-clipboard menu-icon"></i><span>Kuisioner</span></a>
                        </li>
                    @endif

                    <!-- Menu ini hanya untuk role 'tim peneliti' -->
                    @if (Auth::check() && Auth::user()->role === 'tim peneliti')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tim_peneliti.dashboard') }}"><i
                                    class="ti ti-home menu-icon"></i><span>Dashboard</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tim_peneliti.pasien.index') }}"><i
                                    class="fas fa-bed menu-icon"></i><span>Pasien</span></a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator.pasien.index') }}"><i
                                    class="ti ti-list-check menu-icon"></i><span>Kuisioner</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator.pasien.index') }}"><i
                                    class="ti ti-file-report menu-icon"></i><span>Hasil Test</span></a>
                        </li>
                    @endif

                </ul><!--end navbar-nav--->
            </div><!--end sidebarCollapse-->
        </div>
    </div>
</div>
