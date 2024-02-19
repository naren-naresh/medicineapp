<header class="bg-light">
    <section id="nav-section">
        <nav class="container-fluid navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand ps-5" href="#"><img src="{{ asset('assets/images/logo.png') }}" alt=""
                style="width: 150px"></a>
            {{-- sidebar toggle --}}
            <button type="button" class="btn navbar-toggle collapsed bg-transparent text-white" data-toggle="collapse" id="menu-toggle">
                <span class="fa fa-bars" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn navbar-toggle collapsed bg-transparent text-white" data-toggle="collapse" id="menu-toggle-2">
                <span class="fa fa-bars" aria-hidden="true"></span>
            </button>
            {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> --}}
            <div class="nav-elements ms-auto" id="navbarNav">
                <ul class="dropdown mt-1" style="right:36px">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" id="navbarDropdown"><img src="{{asset('assets/images/logo_cut.png')}}" alt="logo-cut-image" style="width: 30px; border-radius:50%;">{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu me-5" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="">Profile</a></li>
                        <li><a class="dropdown-item" href="" id="btn" data-bs-toggle="modal"
                                data-bs-target="#myModal">Change Password</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </ul>
            </div>
        </nav>
</header>
