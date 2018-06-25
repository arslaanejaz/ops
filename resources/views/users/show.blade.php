@extends('layouts.app')

@section('content')

    <h1>User</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>ID.</th><th>Email</th><th>Name</th>
            </tr>
            <tr>
                <td>{{ $user->id }}</td><td>{{ $user->email }}</td><td>{{ $user->name }}</td>
            </tr>
        </table>
    </div>

@endsection
