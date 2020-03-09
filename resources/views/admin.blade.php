@extends('layouts.header')
@push('scripts')
<script>
    // push blade variables to JS
</script>
<script src="{{ asset('js/crypto.js')}}" defer></script>
@endpush
@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">
            Admin panel
        </div>
        <div class="card-body">
            <p class="card-text">You can manage your users here<p>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Admin ?</th>
                        <th scope="col">Total money</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr onClick="window.location='{{ route('user.edit', $user->id) }}'">
                        <th scope="row">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->isAdmin ? 'yes' : 'no' }}</td>
                        <td>{{ rand(0, 1000) }} € (fake)</td>
                        <td>
                        <form method="POST" action="{{ route('user.destroy', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <a class="btn btn-primary" href="{{ route('user.edit', $user->id) }}">Modify</a>
                            <button class="btn btn-danger" href="{{ route('user.destroy', $user->id) }}">Delete</button>
                        </form>
                        </td>
                    </tr>
                    @empty
                        <p>No users</p>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('home') }}" class="btn btn-info">Go back to home</a>
        </div>
    </div>

</div>
@endsection