@extends('layouts.menu')

@section('content')

<div class="card">
  <div class="card-header">
    {{ $userData->name }}
  </div>
<form class="card-body" type="POST" action="/admin/{{ $userData->id }}">
    <h5 class="card-title">User crud here lol</h5>
    <p class="card-text">You must push the button "Modify" to apply modifications</p>
    <div class="form-group">
        <label for="changeUserName">Modify user name</label>
        <input type="text" class="form-control" id="changeUserName" aria-describedby="usernameHelp" value="{{ $userData->name }}">
        <small id="usernameHelp" class="form-text text-muted">Woaw you'll change your user name :o</small>
        <button type="submit" class="btn btn-info">Modify</button>
    </div>
    <div class="form-group">
        <label for="changeUserEmail">Modify user email</label>
        <input type="email" class="form-control" id="changeUserEmail" aria-describedby="usernameHelp" value="{{ $userData->email }}">
        <small id="usernameHelp" class="form-text text-muted">Woaw you'll change your user email :o</small>
        <button type="button" class="btn btn-info">Modify</button>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="isAdmin" {{ $userData->isAdmin ? 'checked' : '' }}>
    <label class="form-check-label" for="isAdmin">
        is this user Admin ?
    </label>
    </div>
    <button type="button" class="btn btn-danger">Delete User</button>
    <a href="#" class="btn btn-primary">Idk</a>
</form>
</div>

<div class="container">

    <p>User crud here lol</p>

    <p>
        {{ $userData }}
    </p>

</div>
@endsection