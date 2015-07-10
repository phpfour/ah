@extends('layouts.master')

@section('title', 'Search Results')

@section('content')

    @include('partials.searchform')

    <div class="row">

        @if ($results)
            <div class="col-md-9 job-list">

                <h3>Search Results</h3>
                <p>Total result: <strong>{{ $count }}</strong>. Showing from {{ $range[0] }} to {{ $range[1] }}.</p>
                <nav>
                    <ul class="pager">
                        <li class="previous @if (!$previousPageUrl) disabled @endif"><a href="{{ $previousPageUrl }}"><span aria-hidden="true">&larr;</span> Previous</a></li>
                        <li class="next @if (!$nextPageUrl) disabled @endif"><a href="{{ $nextPageUrl }}">Next <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </nav>

                @foreach($results as $job)
                <div class="job-list-item" id="job-{{ $job->id }}">
                    <h3><a href="/jobs/{{ $job->id }}">{!! $job->title !!}</a></h3>
                    <div class="text-muted small">
                        Posted by <strong>{{ $job->company }}</strong> on {{ $job->postDate }}
                    </div>
                    <p class="blurb">{!! $job->blurb !!}</p>

                    <div class="meta clearfix" style="background-color: #fafafa; padding: 5px 10px">
                        <div class="pull-left">
                            <i class="fa fa-map-marker"></i> {{ $job->location }}
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs"><i class="fa fa-save"></i> Save</a>
                            <a class="btn btn-default btn-xs"><i class="fa fa-envelope-o"></i> Email</a>
                            <a class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Apply</a>
                        </div>
                    </div>

                </div>
                @endforeach

            </div>
        @else
            <div class="col-md-9 job-list">
                <div class="alert alert-warning">Sorry, no results found for the provided search criteria.</div>
            </div>
        @endif

        <div class="col-md-3 sidebar">

            <h4>Filters</h4>

            <div class="filter-box">
                <a class="filter-handle" data-toggle="collapse" href="#filter-relevance" aria-expanded="true" aria-controls="filter-relevance">
                    <i class="fa fa-sort"></i> Sort By
                </a>
                <ul class="list-unstyled collapse in" id="filter-relevance">
                    <li><a href="#"><i class="fa fa-fw fa-circle-o"></i> Relevance</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-circle-o"></i> Date</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-circle"></i> Salary</a></li>
                </ul>
            </div>

            <div class="filter-box">
                <a class="filter-handle" data-toggle="collapse" href="#filter-salary" aria-expanded="true" aria-controls="filter-salary">
                    <i class="fa fa-sort"></i> Salary Range
                </a>
                <ul class="list-unstyled collapse in" id="filter-salary">
                    <li><a href="#"><i class="fa fa-fw fa-circle-o"></i> $60,000+</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-circle"></i> $80,000+</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-circle-o"></i> $100,000+</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-circle-o"></i> $120,000+</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-circle-o"></i> $150,000+</a></li>
                </ul>
            </div>

            <div class="filter-box">
                <a class="filter-handle" data-toggle="collapse" href="#filter-type" aria-expanded="true" aria-controls="filter-type">
                    <i class="fa fa-clock-o"></i> Contract Type
                </a>
                <ul class="list-unstyled collapse in" id="filter-type">
                    <li><a href="#"><i class="fa fa-fw fa-check-square-o"></i> Full-time</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-square-o"></i> Contract</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-square-o"></i> Part-time</a></li>
                </ul>
            </div>

            <div class="filter-box">
                <a class="filter-handle" data-toggle="collapse" href="#filter-tags" aria-expanded="true" aria-controls="filter-tags">
                    <i class="fa fa-tags"></i> Tags
                </a>
                <ul class="list-unstyled collapse in" id="filter-tags">
                    <li><a href="#"><i class="fa fa-fw fa-check-square-o"></i> Symfony</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-square-o"></i> PHP5</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-square-o"></i> ElasticSearch</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-check-square-o"></i> Solr</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-square-o"></i> MySql</a></li>
                </ul>
            </div>
        </div>



    </div>

@endsection