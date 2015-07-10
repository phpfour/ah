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
                    <a href="#" class="btn btn-default btn-sm"><i class="fa fa-save"></i> Save</a>
                    <a href="{{ $job->sourceUrl }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-link"></i> Go to source</a>
                    <a href="#" class="btn btn-default btn-sm"><i class="fa fa-share-alt"></i> Share</a>
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
                    <th><i class="fa fa-fw fa-link"></i> Source</th>
                    <td><a href="{{ $job->sourceUrl }}" target="_blank">See Original <i class="fa fa-share-square-o"></i> </a></td>
                </tr>
                <tr>
                    <th colspan="2">
                        <i class="fa fa-fw fa-globe"></i> Map
                        <p style="margin: 10px 0">
                            <a href="{{ $job->mapUrl }}" target="_blank">{!! $job->staticMap !!}</a>
                        </p>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection