<nav class="navbar bg-base-100 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto w-full px-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl">
                <span class="text-primary text-2xl">📚</span>
                <span class="font-bold">Lab WICIDA</span>
            </a>
        </div>

        <div class="hidden md:flex items-center gap-4">
            <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">Home</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">Dashboard</a>
            @endauth
        </div>

        <div class="flex items-center gap-2">
            <button id="theme-toggle" class="btn btn-ghost btn-circle btn-sm">
                🌗
            </button>

            @auth
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-sm">
                        {{ auth()->user()->name }}
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
            @endauth
        </div>
    </div>
</nav>
