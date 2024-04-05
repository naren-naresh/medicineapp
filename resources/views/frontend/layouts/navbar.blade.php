<div class="page-navbar">
    <div class="container">
        <div class="navbar navbar-expand-lg" id="navbar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="#" class="nav-link dropdown-toggle" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop by Category</a>
                        <ul class="dropdown-menu">
                            @foreach ($parent_categories as $catName )
                             <li><a href="#" class="dropdown-item">{{ $catName->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">About Us</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contact Us</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">FAQ</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
