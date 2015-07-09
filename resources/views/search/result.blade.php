@extends('layouts.master')

@section('title', 'Search Results')

@section('content')

    @foreach($jobs as $job)
    <div>
        <h4>{{{ $job->jobtitle }}}</h4>
    </div>
    @endforeach

@endsection