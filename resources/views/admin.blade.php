@extends('layouts.header')
@push('scripts')
<script>
    // push blade variables to JS
</script>
<script src="{{ asset('js/crypto.js')}}" defer></script>
@endpush
@section('content')

    <div class="card">
        <div class="card-header">
            Admin panel
        </div>
        <div class="card-body">
            <p class="card-text">You can manage your users here<p>
            <div class="table-responsive">
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
        </div>
        <div class="card-footer">
            <a href="{{ route('home') }}" class="btn btn-info">Go back to home</a>
        </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-label">Confirm user deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirm that you want to delete this user ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </div>
        </div>
    </div>

@endsection