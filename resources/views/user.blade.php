@extends('layouts.header')

@section('content')

    <div class="card">
    <div class="card-header">
        {{ $userData->name }}
    </div>
    {{-- <form class="card-body" method="POST" action="/admin/{{ $userData->id }}"> --}}
        <form class="card-body" method="POST" action="{{ route('user.update', $userData->id) }}">
        @csrf
        @method('PUT')
        <h5 class="card-title">User management</h5>
        <p class="card-text">You must push the button "Modify" to apply modifications</p>
        <div class="form-group">
            <label for="changeUserName">Modify user name</label>
            <input name="name" type="text" class="form-control" id="changeUserName" aria-describedby="usernameHelp" value="{{ $userData->name }}">
            <small id="usernameHelp" class="form-text text-muted">Change user name</small>
        </div>
        <div class="form-group">
            <label for="changeUserEmail">Modify user email</label>
            <input name="email" type="email" class="form-control" id="changeUserEmail" aria-describedby="usernameHelp" value="{{ $userData->email }}">
            <small id="usernameHelp" class="form-text text-muted">Change email</small>
        </div>
        <div class="form-check">
        <input name="isAdmin" type="hidden" value="0">
        <input name="isAdmin" class="form-check-input" type="checkbox" value="1" id="isAdmin" {{ $userData->isAdmin ? 'checked' : '' }}>
        <label class="form-check-label" for="isAdmin">
            is this user Admin ?
        </label>
        </div>
        {{-- <a href="{{ route('') }}" class="btn btn-danger">Delete User</a> --}}
        <button type="submit" class="btn btn-primary">Modify</button>
    </form>
    </div>
@endsection
