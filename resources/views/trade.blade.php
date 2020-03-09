@extends('layouts.menu')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">
            Transactions
        </div>
        <div class="card-body">
            <h5 class="card-title">All transactions history</h5>
            <p class="card-text">You can find every transaction you've made on the website.</p>
            @if ($userTransactions)
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Crypto</th>
                        <th scope="col">Crypto quantity</th>
                        <th scope="col">€ Spent</th>
                        <th scope="col">Crypto value when bought €</th>
                        <th scope="col">Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userTransactions as $transaction)
                        <tr>
                        <th scope="row">{{ $transaction['crypto'] }}</th>
                        <td>{{ $transaction['crypto_quantity'] }}</td>
                        <td>{{ $transaction['purchase_quantity'] }}</td>
                        <td>{{ $transaction['purchase_value'] }}</td>
                        <td>{{ $transaction['sold'] ? 'yes' : 'no' }}</td>
                        </tr>
                        @empty
                            <p>Sorry, I didn't found any transactions.</p>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('home') }}" class="btn btn-info">Return to crypto list</a>
        </div>
    </div>

</div>
@endsection