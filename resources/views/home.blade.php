@extends('layouts.master')

@section('title', 'Home')

@section('content')

@include('partials.searchform')

@if(Request::method() === 'POST')
<div class="row">
    <div class="col-md-3">
        sidebar
    </div>
    <div class="col-md-9">
        search result
    </div>
</div>
@endif

@endsection