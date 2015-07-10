@extends('layouts.master')

@section('title', 'Home')

@section('content')

    @include('partials.searchform')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">Please use the search bar above to search for jobs according to your requirements.</div>
        </div>
    </div>

@endsection