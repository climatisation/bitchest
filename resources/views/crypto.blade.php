@extends('layouts.header')
@push('scripts')
<script>
    // push blade variables to JS
    const thirtyDays = @json($thirtyDays ?? '');
    const currentCryptoName = @json($currentCrypto['name'] ?? '');
    const thirtyDaysLabels = (thirtyDays !== '') ? thirtyDays.map((value, index) => index.toString()) : '';

    // $('#myModal').on('shown.bs.modal', function () {
    // $('#myInput').trigger('focus')
    // });
</script>
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush

@section('content')

<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
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
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Crypto</th>
                        <th scope="col">Crypto quantity</th>
                        <th scope="col">€ Spent</th>
                        <th scope="col">Crypto value when bought €</th>
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
                        <td>{{ $transaction['gain'] }} €</td>
                        </tr>
                        @endif
                            {{-- <li class="nav-item">
                                <a class="nav-link {{($cryptoItem->symbol === $currentCrypto['symbol']) ? 'active' : '' }}" href="/crypto/{{$cryptoItem->symbol}}">{{ $cryptoItem->name }}</a>
                            </li> --}}
                        @empty
                            <p>Api error, crypto not found</p>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            <a href="#" class="btn btn-info">Go to full transactions history</a>
        </div>
    </div>

    {{-- {{ $userBalance ?? 'no' }} --}}

    {{-- <ul class="nav nav-pills nav-fill">
    @forelse ($crypto as $cryptoItem)
        <li class="nav-item">
            <a class="nav-link {{($cryptoItem->symbol === $currentCrypto['symbol']) ? 'active' : '' }}" href="/crypto/{{$cryptoItem->symbol}}">{{ $cryptoItem->name }}</a>
        </li>
    @empty
        <p>Api error, crypto not found</p>
    @endforelse
    </ul> --}}
    {{-- <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary btn-block">Buy</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-primary btn-block">Sell</button>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#m-buy">Buy</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#m-sell">Sell</button>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-sm">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-sm">
            <p>History</p>
            @if ($userHistory)
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Crypto</th>
                    <th scope="col">Crypto quantity</th>
                    <th scope="col">€ Spent</th>
                    <th scope="col">Crypto value when bought €</th>
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
                    <td>{{ $transaction['gain'] }} €</td>
                    </tr>
                    @endif
                    @empty
                        <p>Api error, crypto not found</p>
                    @endforelse
                </tbody>
            </table>
            @endif
        </div>
    </div> --}}

    {{-- modals --}}
    {{-- <div class="modal fade" id="m-buy" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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
                        {{-- <button type="button" class="btn btn-primary">Buy</button> --}}
                    {{-- </div>
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
                            {{-- <input type="hidden" name="{{ $transaction['id'] }}" value="default"> --}}
                            {{-- <input type="hidden" value="{{ $transaction['id'] }}">
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
    </div> --}}

</div>

@endsection