<div class="sidebar">
    <div class="navigation">
        <ul>
            <li>
                <a href="{{ route('dashboard') }}">
                    <span class="icon"><i class="fa fa-list-alt" aria-hidden="true"></i></span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('orders.index') }}">
                    <span class="icon"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i></span>
                    <span class="title">Objednávky</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tables.index') }}">
                    <span class="icon"><i class="fas fa-user-friends" aria-hidden="true"></i></span>
                    <span class="title">Obsadenosť</span>
                </a>
            </li>
            <li>
                <a href="{{ route('statistics') }}">
                    <span class="icon"><i class="fas fa-chart-line" aria-hidden="true"></i></span>
                    <span class="title">Štatistiky</span>
                </a>
            </li>
            <li>
                <a href="{{ route('products.index') }}">
                    <span class="icon"><i class="fas fa-hamburger" aria-hidden="true"></i></span>
                    <span class="title">Ponuka</span>
                </a>
            </li>
            <li>
                <a href="{{ route('employees.index') }}">
                    <span class="icon"><i class="fas fa-users" aria-hidden="true"></i></span>
                    <span class="title">Zamestnanci</span>
                </a>
            </li>
            <li>
                <a href="{{ route('orders.create') }}">
                    <span class="icon"><i class="fas fa-cart-plus" aria-hidden="true"></i></span>
                    <span class="title">Nová objednávka</span>
                </a>
            </li>
            <hr>
            <li>
                <a href="{{ route('users.edit', Auth::user()) }}">
                    <span class="icon"><i class="fas fa-address-card"></i></span>
                    <span class="title">Profil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="title">Odhlásiť</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    
    <div class="toggle" onclick="toggleMenu()"></div>
</div>

<div class="overlay"></div>

<script>
    function toggleMenu() {
        let overlay = document.querySelector('.overlay');
        let navigation = document.querySelector('.navigation');
        let toggle = document.querySelector('.toggle');
        navigation.classList.toggle('active');
        toggle.classList.toggle('active');
        overlay.classList.toggle('active');
    }
</script>