@extends('layouts.master')

@section('title', 'Home')

@section('content')

@include('partials.searchform')

<div class="row">
    <div class="col-md-8">
        <h2>{!! $job->title !!}</h2>
        <p class="text-muted">Posted by <strong>{{ $job->company }}</strong> on {{ $job->postDate }}</p>
        <p>{!! $job->description !!}</p>
    </div>

    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-body text-center">
                <p>
                    <button class="btn btn-success">Apply Online</button>
                    <button class="btn btn-primary">Apply via Email</button>
                </p>
                <p>
                    <button class="btn btn-default btn-sm"><i class="fa fa-save"></i> Save</button>
                    <button class="btn btn-default btn-sm"><i class="fa fa-link"></i> Go to source</button>
                    <button class="btn btn-default btn-sm"><i class="fa fa-share-alt"></i> Share</button>
                </p>
            </div>
        </div>

        <table class="table">
            <tbody>
                <tr>
                    <th><i class="fa fa-fw fa-building"></i> Company</th>
                    <td>{{ $job->company }}</td>
                </tr>
                <tr>
                    <th><i class="fa fa-fw fa-map-marker"></i> Location</th>
                    <td>{{ $job->location }}</td>
                </tr>
                <tr>
                    <th><i class="fa fa-fw fa-calendar"></i> Posted On</th>
                    <td>{{ $job->postDate }}</td>
                </tr>
                <tr>
                    <th><i class="fa fa-fw fa-globe"></i> Map</th>
                    <td><a href="{{ $job->mapUrl }}" target="_blank">Open with Google Map</a></td>
                </tr>
                <tr>
                    <th><i class="fa fa-fw fa-link"></i> Source</th>
                    <td><a href="{{ $job->sourceUrl }}" target="_blank">See Original <i class="fa fa-share-square-o"></i> </a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection