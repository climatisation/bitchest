@extends('layouts.header')

@section('menu')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 border-right">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ ((request()->is('crypto')) || (request()->is('crypto/'.($currentCrypto['symbol'] ?? '' )))) ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{ route('portfolio') }}">Trade</a>
                </li>
                @if ($isAdmin ?? '' && $isAdmin === true)
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin')) ? 'active' : '' }}" href="{{ route('user.index') }}">Clients</a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>
<!-- <div class="container"> -->
    <!-- <div class="row justify-content-center"> -->
        <!-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div> -->
    <!-- </div> -->
<!-- </div> -->
@endsection
