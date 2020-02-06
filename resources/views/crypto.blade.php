@extends('layouts.menu')
@push('scripts')
<script src="{{ asset('js/chart.js')}}" defer></script>
@endpush
@section('crypto')
<div>
<p>LOLOLOLCONTENT</p>
<div>
<canvas id="myChart" width="800" height="400"></canvas>
</div>
</div>
@endsection