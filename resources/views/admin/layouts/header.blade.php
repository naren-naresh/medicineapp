<header class="bg-light">
    <section id="nav-section">
        <nav class="container-fluid navbar navbar-expand-md">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo_white.png') }}" alt="Medicine App Logo" style="width: 144px">
            </a>
            <!-- sidebar toggle -->
            <button type="button" class="btn navbar-toggle collapsed bg-transparent text-white" data-toggle="collapse"
                id="menu-toggle">
                <span class="fa fa-bars" aria-hidden="true"></span>
            </button>
            {{-- <button type="button" class="btn navbar-toggle collapsed bg-transparent text-white" data-toggle="collapse"
                id="menu-toggle-2">
                <span class="fa fa-bars" aria-hidden="true"></span>
            </button> --}}
            <div class="nav-elements ms-auto" id="navbarNav">
                <ul class="dropdown mt-1" style="right:60px">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" id="navbarDropdown">
                        <img src="{{ asset('assets/images/logo_cut.png') }}" alt="logo-cut-image"
                            style="width: 30px; border-radius:50%;">&nbsp;{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu me-5" aria-labelledby="navbarDropdown" style="background-color:#385399;">
                        <li><a class="dropdown-item text-white" href="{{ route('profile')}}"><i class="fa fa-user"></i> &nbsp;Profile</a></li>
                        <li><a class="dropdown-item text-white" href="" id="btn" data-bs-toggle="modal"
                                data-bs-target="#myModal"><i class="fa fa-keyboard"></i> &nbsp;Change Password</a></li>
                        <li><a class="dropdown-item text-white" href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> &nbsp;Logout</a></li>
                    </ul>
                </ul>
            </div>
        </nav>
</header>
