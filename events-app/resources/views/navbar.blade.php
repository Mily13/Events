<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><i class="bi bi-calendar2-event me-2"></i> Mozaik Events</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Mozaik Events Demo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-house-fill navText me-2"></i>Dashboard</a>
                    </li>
                    @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}"><i class="bi bi-person-circle navText me-2"></i>My Profile</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link" id="logout-button">
                                <i class="bi bi-box-arrow-in-left navText me-2"></i>LogOut
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right navText me-2"></i>LogIn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signup') }}"><i class="bi bi-r-circle-fill navText me-2"></i>SignUp</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
