@extends('layouts.menu')
@push('scripts')
<script>
    // push blade variables to JS
    const thirtyDays = @json($thirtyDays ?? '');
    const currentCryptoName = @json($currentCrypto['name'] ?? '');
    const thirtyDaysLabels = (thirtyDays !== '') ? thirtyDays.map((value, index) => index.toString()) : '';

    $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
    });
</script>
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush

@section('content')

<div class="container">

    <ul class="nav justify-content-center">
    @forelse ($crypto as $cryptoItem)
        <li class="nav-item">
            <a class="nav-link {{($cryptoItem->symbol === $currentCrypto['symbol']) ? 'active' : '' }}" href="/crypto/{{$cryptoItem->symbol}}">{{ $cryptoItem->name }}</a>
        </li>
    @empty
        <p>Api error, crypto not found</p>
    @endforelse
    </ul>
    {{-- <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary btn-block">Buy</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-primary btn-block">Sell</button>
        </div>
    </div> --}}
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#m-buy">Buy</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#m-sell">Sell</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-sm">
            <p>History</p>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- modals --}}
    <div class="modal fade" id="m-buy" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Buy {{ $currentCrypto['name'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tell me how much you would like to buy : </p>
                    <input type="number" />
                    <span>€</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Buy</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m-sell" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Sell {{ $currentCrypto['name'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Choose what you want to sell : </p>
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Buy</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection