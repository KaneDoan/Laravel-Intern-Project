@if(Auth::check())
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="sidebar navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-tv"></i>
                    <span>Gym Control</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('gyms.index')}}">
                    <i class="fas fa-building"></i>
                    <span>Gym Manager</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="pagesDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fas fa-folder"></i>
                    <span>Workout Manager</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item" href="{{route('routines.index')}}">Routines</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('exercises.index')}}">Exercises</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-user-lock"></i>
                    <span>User Manager</span>
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
