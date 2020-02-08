@extends('layouts.menu')
@push('scripts')
<script>
    // push blade variables to JS
    const thirtyDays = @json($thirtyDays);
    const thirtyDaysLabels = thirtyDays.map((value, index) => index.toString());
</script>
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush

@section('crypto')

{{-- {{$currentCrypto ?? ''}} --}}

<ul class="nav justify-content-center">
@forelse ($crypto as $crypoItem)
        <li class="nav-item">
            <a class="nav-link" href="/crypto/{{$crypoItem->symbol}}">{{ $crypoItem->name }}</a>
        </li>
@empty
        <p>No Crypto</p>
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