@extends('layouts.app')

@section('content')
<div class="container">
    
    
    
    
<div class="card card-body">
    <h3>project Idea</h3>
    <form method='post' action="{{ url('/welcome') }}"  >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" >
    </div>
    <div class="form-group">
        <label for="details">Details</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>
@endsection
