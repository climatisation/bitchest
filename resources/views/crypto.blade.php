@extends('layouts.header')
@push('scripts')
<script>
    // push blade variables to JS
    const thirtyDays = @json($thirtyDays ?? '');
    const currentCryptoName = @json($currentCrypto['name'] ?? '');
    // const thirtyDaysLabels = (thirtyDays !== '') ? thirtyDays.map((value, index) => index.toString()) : '';

</script>
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush

@section('content')

    <div class="card mb-3">
        <div class="card-header">
            {{ $currentCrypto['name'] }}
        </div>
        <div class="card-body">
        <h5 class="card-title display-3 text-monospace">{{ session('crypto_price') }} €</h5>
        </div>
        <canvas id="myChart"></canvas>
        <div class="card-footer">
            <a href="{{ route('home') }}" class="btn btn-info">Return to crypto list</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Transactions (wallet)
        </div>
        <div class="card-body">
            <p class="card-text">Transactions representing wallet<p>
            @if ($userHistory)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Crypto</th>
                        <th scope="col">Crypto quantity</th>
                        <th scope="col">€ Spent</th>
                        <th scope="col">Crypto value when bought €</th>
                        <th scope="col">Transaction value today €</th>
                        <th scope="col">Gain</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userHistory as $transaction)
                        @if (!$transaction['sold'])
                        <tr>
                        <th scope="row">{{ $transaction['crypto'] }}</th>
                        <td>{{ $transaction['crypto_quantity'] }}</td>
                        <td>{{ $transaction['purchase_quantity'] }}</td>
                        <td>{{ $transaction['purchase_value'] }}</td>
                        <td>{{ number_format($transaction['today_cryp_quant_eur'], 2) }}</td>
                        <td>{{ number_format($transaction['gain'], 2) }} €</td>
                        </tr>
                        @endif
                        @empty
                            <p>Api error, crypto not found</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('portfolio') }}" class="btn btn-info">Go to full transactions history</a>
        </div>
    </div>

@endsection