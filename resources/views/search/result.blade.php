@extends('layouts.master')

@section('title', 'Search Results')

@section('content')

    @foreach($results as $job)
    <div>
        <h4>{!! $job->title !!}</h4>
        <p>{!! $job->blurb !!}</p>
    </div>
    @endforeach

@endsection