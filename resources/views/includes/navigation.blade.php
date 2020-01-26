<nav class="bg-gray-300 text-gray-900">
    <div class="container flex justify-between p-4">
        <!-- Left Side Of Navbar -->
        <div class="flex">
            <a class="font-semibold mr-4" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div class="flex text-blue-500">
                <a href="{{ route('threads.index') }}">{{ __('All Threads') }}</a>
                <dropdown v-cloak>
                    <span slot="toggler" class="m-2">Browse Threads</span>
                    <span slot="items">
                        <div class="p-4">
                            <a class="ml-4"
                                href="{{ route('threads.index') }}?popular=1">{{ __('Popular Threads') }}</a>
                            <a class="ml-4"
                                href="{{ route('threads.index') }}?most_visited=1">{{ __('Most Visited Threads') }}</a>
                            <a class="ml-4"
                                href="{{ route('threads.index') }}?unanswer=1">{{ __('Unanswered Threads') }}</a>
                            @auth
                            <a class="ml-4"
                                href="{{ route('threads.index') }}?by={{auth()->user()->name}}">{{ __('My Threads') }}</a>
                            @endauth
                        </div>
                    </span>
                </dropdown>
                <a  href="{{ route('threads.create') }}">{{ __('Create Threads') }}</a>

            </div>
        </div>
        <!-- Right Side Of Navbar -->
        <div class="flex">
            <!-- Authentication Links -->
            @guest
            @if (Route::has('register'))
            <a class="ml-2 px-2 pb-1 text-blue-500 border border-blue-500 rounded align-baseline hover:text-blue-700 hover:border-blue-700" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
            <a class="ml-2 text-blue-500" href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
            <user-notifications></user-notifications>
            <dropdown v-cloak>
                <p slot="toggler">{{ Auth::user()->name }}</p>
                <span slot="items" class="flex flex-col">
                    <a href="{{ route('profile.show',Auth::user()) }}">
                        {{ __('My Profile') }}
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </span>
            </dropdown>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
        </div>
    </div>
</nav>