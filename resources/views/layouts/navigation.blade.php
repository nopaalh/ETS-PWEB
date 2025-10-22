<nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
        
        {{-- Logo --}}
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-green-800 flex items-center gap-1">
                    🌿 <span>Pendakianku</span>
                </a>
            @else
                <a href="{{ route('landing') }}" class="text-2xl font-bold text-green-800 flex items-center gap-1">
                    🌿 <span>Pendakianku</span>
                </a>
            @endauth
        </div>

        {{-- Menu navigasi --}}
        <div class="hidden md:flex space-x-8 font-medium text-gray-700">
            @auth
                <a href="{{ route('mountain.index') }}" 
                   class="{{ request()->is('mountain*') ? 'text-green-700 font-semibold' : 'hover:text-green-700 transition' }}">
                    Mountains
                </a>
                <a href="{{ route('checkout.index') }}" 
                   class="{{ request()->is('checkout*') ? 'text-green-700 font-semibold' : 'hover:text-green-700 transition' }}">
                    Ticket
                </a>
                <a href="{{ route('favorite.index') }}" 
                   class="{{ request()->is('favorite*') ? 'text-green-700 font-semibold' : 'hover:text-green-700 transition' }}">
                    Favorite
                </a>
                <a href="{{ route('history.index') }}" 
                   class="{{ request()->is('history*') ? 'text-green-700 font-semibold' : 'hover:text-green-700 transition' }}">
                    History
                </a>
            @endauth
        </div>

        {{-- Auth buttons --}}
        <div>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-green-700 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-green-800 transition">
                        Keluar
                    </button>
                </form>
            @else
                <div class="flex gap-4 items-center">
                    <a href="{{ route('login') }}" class="text-green-800 hover:underline font-medium">Masuk</a>
                    <a href="{{ route('register') }}" 
                       class="bg-green-700 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-green-800 transition">
                       Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
