@extends('layouts.header')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 test">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#">BTC (active)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">LTC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ETH</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">XRP</a>
                </li>
            </ul>
            <div class="row">
                @yield('crypto')
            </div>
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
