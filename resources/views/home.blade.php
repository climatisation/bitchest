@extends('layouts.header')
@push('scripts')
<script>
    // push blade variables to JS
    const allCryptosData = @json($multiCryptos);
</script>
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush

@section('content')

    <div class="row row-cols-1 row-cols-md-5">

        @foreach ($multiCryptos as $crypto => $value)
            <div class="col mb-5">
            <a href="{{ route('crypto', $value['symbol']) }}" class="card ptr hov">
            <div class="card-body">
                <h5 class="card-title">{{ $crypto }}</h5>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
            <canvas id="{{ $value['symbol'] }}-30"><canvas>
            </a>
        </div>
        @endforeach

    </div>

@endsection