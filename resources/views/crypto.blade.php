@extends('layouts.menu')
@push('scripts')
<script>
    // push blade variables to JS
    const thirtyDays = @json($thirtyDays ?? '');
    const currentCryptoName = @json($currentCrypto['name']);
    const thirtyDaysLabels = thirtyDays.map((value, index) => index.toString());
</script>
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush

@section('crypto')

<ul class="nav justify-content-center">
@forelse ($crypto as $cryptoItem)
    <li class="nav-item">
        <a class="nav-link {{($cryptoItem->symbol === $currentCrypto['symbol']) ? 'active' : '' }}" href="/crypto/{{$cryptoItem->symbol}}">{{ $cryptoItem->name }}</a>
    </li>
@empty
    <p>Api error, crypto not found</p>
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