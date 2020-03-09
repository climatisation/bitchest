<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BitChest') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'BitChest') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">



                        @guest
                        @if (Route::has('register'))
                        @endif
                        @else
                        <li>Balance : {{ Auth::user()->balance }}</li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @isset ($currentCrypto)
                        <li class="btn-group" role="group" aria-label="buy-sell">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m-buy">Buy</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m-sell">Sell</button>                            
                        </li>
                        @endisset
                    {{-- <p>
                        {{ $userBalance ?? 'np' }}
                    </p> --}}
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        Dashboard
                                    </a>
                                    <a class="dropdown-item" href="{{ route('portfolio') }}">
                                        Portfolio
                                    </a>
                                    @if ($isAdmin ?? '' && $isAdmin === true)
                                        <a class="dropdown-item {{ (request()->is('admin')) ? 'active' : '' }}" href="{{ route('user.index') }}">Clients</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    {{-- <form id="dashboard" action="{{ route('home') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <form id="portfolio" action="{{ route('portfolio') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form> --}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @isset ($currentCrypto)
        <div class="modal fade" id="m-buy" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Buy {{ $currentCrypto['name'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="/buy/{{ $currentCrypto['symbol'] }}">
                        @csrf
                        <div class="modal-body">
                            <p>Tell me how much you would like to buy : </p>
                                <input name="quantity" type="number" />
                                <span>€</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Buy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="m-sell" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <form method="POST" action="/crypto">
                @csrf
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Sell {{ $currentCrypto['name'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($userHistory)
                        <p>Choose what you want to sell : </p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">Crypto</th>
                                <th scope="col">Crypto quantity</th>
                                <th scope="col">Gain</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($userHistory as $transaction)
                                @if (!$transaction['sold'])
                                <tr class="ptr" onClick={toggleSelected(this)}>
                                <th scope="row">{{ $transaction['crypto'] }}</th>
                                <td>{{ $transaction['crypto_quantity'] }}</td>
                                <td>{{ $transaction['gain'] }} €</td>
                                <input type="hidden" value="{{ $transaction['id'] }}">
                                </tr>
                                @endif
                                @empty
                                    <p>Api error, nothing found.</p>
                                @endforelse                        
                            </tbody>
                        </table>
                        @else
                        <p>You have no transactions.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sell</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        @endisset
    </div>
    <script>
        function toggleSelected(e) {
            $(e).toggleClass('selected');

            let input = $(e).find('input');

            input.attr('name') == 'selected' ? input.removeAttr('name') : input.attr('name', 'selected[]');

            // input.val() == 'selected' ? input.val('default') : input.val('selected');

        }
    </script>
</body>
</html>
