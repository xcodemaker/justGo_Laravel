@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

    <div class="jumbotron text-center">
    <h1 class="display-3">welcome</h1>
    <p class="lead">Jot down ideas for your next  projects</p>
    <a href="{{ url('project/create') }}" class="btn btn-dark btn-lg">Add project Idea</a>
</div>
                </div>
            </div>
        </div>
    </div>
<br>
<br>
@foreach($data as $idea)
    <div class="card card-body mb-2">
    <div class="row">
    <div class="col-9">
    <h4>{{$idea->title}}</h4>
    <p>{{$idea->description}}</p>
    </div>
    <div class="col-3">
    <label for=""><h5>Status : </h5></label>
    @if($idea->status=="pending")
    <a class="btn btn-block mb-2" style="background-color:#00AEFF; color:white;" >Pending</a>
    @elseif($idea->status=="Accept")
    <a class="btn btn-block mb-2" style="background-color:#089000; color:white;" >Accept</a>
    @else
    <a class="btn btn-block mb-2" style="background-color:#FE0000; color:white;" >Decline</a>
    @endif
    </div>
    </div>
    <a class="btn btn-dark btn-block mb-2" href="{{ url('/project/edit/'.$idea->id) }}">Edit</a>
    <a class="btn btn-danger btn-block mb-2" href="{{ url('/project/delete/'.$idea->id) }}">Delete</a>
</div>
@endforeach
</div>
@endsection
