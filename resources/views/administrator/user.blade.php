@extends('layouts.app')


@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>User Management</h2>
        </div>
        <div class="pull-right">
        
            <a class="btn btn-success" href="">Add User</a>
       
        </div>
        <br>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif


<table class="table table-bordered">
  <tr>
     <th>No</th>
     <th>Name</th>
     <th width="280px">Action</th>
  </tr>
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>
            @if($user->isAdmin==1)
            <a class="btn btn-info" >Admin</a>
            @else
            <a class="btn btn-info" >User</a>
            @endif
            
            @if ( auth()->user()->isAdmin() )
                <a class="btn btn-primary" href="{{ url('/admin/user/edit/'.$user->id) }}">Edit</a>
                @if($user->isAdmin==0)
                <a class="btn btn-danger" style="display:inline" href="{{ url('/admin/user/destroy/'.$user->id) }}">Delete</a>
                @endif
            @endif
        </td>
    </tr>
    @endforeach
</table>
<div class="container">
@endsection