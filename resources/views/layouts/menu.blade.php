@extends('layouts.header')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 test">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Trade</a>
                </li>
                @if ($isAdmin === true)
                    <li class="nav-item">
                        <a class="nav-link" href="#">Clients</a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-md-10">
            @yield('crypto')
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
