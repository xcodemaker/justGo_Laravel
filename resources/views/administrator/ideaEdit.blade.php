@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card card-body mb-2">
    <div class="row">
    <div class="col-9">
    <h4>{{$data->title}}</h4>
    <p>{{$data->description}}</p>
    </div>
    <div class="col-3">
    <label for=""><h5>Status : </h5></label>
    <a class="btn btn-block mb-2" style="background-color:#00AEFF; color:white;" >{{$data->status}}</a>
    </div>
    </div>
    <a class="btn btn-dark btn-block mb-2" href="{{ url('/admin/idea/remove/'.$data->id) }}">Remove</a>
    <div class="row">
    <div class="col-6">
    <a class="btn btn-block mb-2" style="background-color:#089000; color:white;" href="{{ url('/admin/idea/accept/'.$data->id) }}" >Accept</a> 
    </div>
    <div class="col-6">
    <a class="btn btn-block mb-2" style="background-color:#FE0000; color:white;" href="{{ url('/admin/idea/decline/'.$data->id) }}" >Decline</a>
    </div>
    </div>
</div>


</div>
@endsection
