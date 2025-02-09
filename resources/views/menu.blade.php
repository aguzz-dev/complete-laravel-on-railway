<div class="hamburger-menu">
    <button class="hamburger-button" aria-label="Abrir/Cerrar menú">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <nav class="menu-items">
        <div class="menu-header">
            Menú
        </div>
        @if (\Illuminate\Support\Facades\Auth::user()->status === 'superadmin')
            <a href="{{ route('dashboard') }}">Listado de Vales</a>
        @endif
        <a href="{{ route('seleccionar') }}">Selecciónar raciones</a>
        <a href="{{ route('misVales') }}">Mis vales</a>
        <a href="{{route('perfil')}}">Perfil</a>
        <a style="color: #34d399;" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión
        </a>
    </nav>
</div>

<form id="logout-form" action="{{ route('logout-user') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
    .hamburger-menu {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1000;
    }

    .hamburger-button {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        width: 2rem;
        height: 2rem;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
        z-index: 1002;
        position: relative;
    }

    .hamburger-button span {
        width: 2rem;
        height: 0.25rem;
        background: #fff;
        border-radius: 10px;
        transition: all 0.3s linear;
        position: relative;
        transform-origin: 1px;
    }

    .hamburger-button.open span:first-child {
        transform: rotate(45deg);
    }

    .hamburger-button.open span:nth-child(2) {
        opacity: 0;
    }

    .hamburger-button.open span:nth-child(3) {
        transform: rotate(-45deg);
    }

    .menu-items {
        position: fixed;
        top: 0.2rem;
        left: 0rem;
        background-color: #1C2533;
        border-radius: 10px;
        display: none;
        flex-direction: column;
        padding: 1rem;
        z-index: 1001;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        max-width: calc(100% - 5rem);
        max-height: calc(100vh - 2rem);
        overflow-y: auto;
    }

    .menu-items.open {
        display: flex;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .menu-header {
        position: relative;
        top: -5px;
        color: #34d399;
        font-size: 1.5rem;
        padding: 0.5rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 1rem;
        text-align: right;
    }

    .menu-items a {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 5px;
    }

    .menu-items a:hover {
        background-color: rgba(0, 209, 178, 0.1);
        color: #00D1B2;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerButton = document.querySelector('.hamburger-button');
        const menuItems = document.querySelector('.menu-items');

        function toggleMenu() {
            hamburgerButton.classList.toggle('open');
            menuItems.classList.toggle('open');
        }

        hamburgerButton.addEventListener('click', toggleMenu);

        // Cerrar el menú al hacer clic en un enlace
        const menuLinks = document.querySelectorAll('.menu-items a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (!this.hasAttribute('onclick')) { // No cerrar en el botón de logout
                    toggleMenu();
                }
            });
        });

        // Cerrar el menú al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            const isClickInside = menuItems.contains(event.target) || hamburgerButton.contains(event.target);
            if (!isClickInside && menuItems.classList.contains('open')) {
                toggleMenu();
            }
        });
    });
</script>
