@extends('layouts.app')

@section('content')
<div class="container">
    
    
    
    
<div class="card card-body">
    <h3>project Idea</h3>
 
    <form method='post' action="{{ url('/project/update/'.$data1->id) }}"  >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" value="{{$data1->title}}" >
    </div>
    <div class="form-group">
        <label for="details">Details</label>
        <input name="description" class="form-control" value="{{$data1->description}}">
    </div>
    <button type="submit" class="btn btn-primary">Edit</button>
    </form>
    
</div>
</div>
@endsection
