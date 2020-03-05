@extends('layouts.menu')

@section('content')

<div class="container">

<h2>Admin panel</h2>

    <table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Admin ?</th>
            <th scope="col">Total money</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
        <tr onClick="window.location='/admin/{{ $user->id }}'">
            <th scope="row">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->isAdmin ? 'yes' : 'no' }}</td>
            <td>100 € (fak)</td>
        </tr>
        @empty
            <p>No users</p>
        @endforelse
      <!--   <tr>
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
        </tr> -->
    </tbody>
    </table>

</div>
@endsection