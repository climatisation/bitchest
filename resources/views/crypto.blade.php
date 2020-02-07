@extends('layouts.menu')
@push('scripts')
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush

@section('crypto')

<ul class="nav justify-content-center">
@forelse ($crypto as $crypoItem)
        <li class="nav-item">
            <a class="nav-link" href="#">{{ $crypoItem->name }}</a>
        </li>
@empty
        <p>No users</p>
@endforelse
</ul>
<div class="row">
    <div class="col-sm">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-sm"></div>
    <div class="col-sm"></div>
</div>
@endsection