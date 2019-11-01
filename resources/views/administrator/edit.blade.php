@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/admin/user/update/'.$users->id) }}" aria-label="Register">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$users->name}}" required autofocus readonly>

                                                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{$users->email}}" required readonly>

                                                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">User type</label>

                            <div class="col-md-6">
                            <div>
            <input type="radio" id="huey" name="isAdmin" value="0" checked />
            <label for="huey">User</label>
        </div>

        <div>
            <input type="radio" id="dewey" name="isAdmin" value="1" />
            <label for="dewey">Admin</label>
        </div>

                                                            </div>
                        </div>

                       

                       

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection