<!-- resources/views/layouts/sidebar.blade.php -->
<div class="d-flex flex-column bg-dark text-white vh-100 p-3" style="width: 250px;">
    <h3 class="mb-4">Menu</h3>

    @auth
        @if(auth()->user()->type === 'admin')
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.cities.index') }}" class="nav-link text-white {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                        Cities
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.trips.index') }}" class="nav-link text-white {{ request()->routeIs('admin.trips.*') ? 'active' : '' }}">
                        Trips
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.buses.index') }}" class="nav-link text-white {{ request()->routeIs('admin.buses.*') ? 'active' : '' }}">
                        Buses
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link text-white {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        Bookings
                    </a>
                </li>
            </ul>
        @else
            {{-- قائمة المستخدم العادي --}}
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('user.bookings.index') }}" class="nav-link text-white {{ request()->routeIs('user.bookings.index') ? 'active' : '' }}">
                        My Bookings
                    </a>
                </li>
                <li class="nav-item mb-2">
                  <a href="{{ route('user.bookings.create') }}" class="nav-link text-white {{ request()->routeIs('user.bookings.create') ? 'active' : '' }}">
                        Book a Trip
                    </a>
                </li>
            </ul>
        @endif
    @endauth
</div>
