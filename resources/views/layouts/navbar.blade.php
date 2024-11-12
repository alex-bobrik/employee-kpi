

<nav class="navbar navbar-expand-xl navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="{{ route('employeeList') }}">Employee KPI</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('employeeList') }}">
                    Employee
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('kpiList') }}">
                    KPI
                </a>
            </li>
            @if (auth()->user()->role == 'admin' )
            <li class="nav-item">
                <a class="nav-link" href="{{ route('managerList') }}">
                    Managers
                </a>
            </li>
            @endif
            
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('logout')}}">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
