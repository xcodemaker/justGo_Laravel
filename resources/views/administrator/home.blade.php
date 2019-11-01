@extends('layouts.app')

@section('content')
<div class="container">
    
<div class="card card-body mb-2">
    <a class="btn btn-dark btn-block mb-2" href="{{ url('/admin/user') }}">User control</a>
    <a class="btn  btn-block mb-2" style="background-color:#430064; color:white;" href="{{ url('/admin/ideas') }}">Ideas control</a>
    <a class="btn  btn-block mb-2" style="background-color:#089000; color:white;" href="{{ url('/admin/reports/user') }}">Export user Report</a>
    <a class="btn  btn-block mb-2" style="background-color:#089000; color:white;" href="{{ url('/admin/reports/projects') }}">Export Project idea Report</a>   
</div>
    
    

</div>
@endsection
