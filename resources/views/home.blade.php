@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div class="row">

    <form class="form-inline" role="form" method="post">
        <div class="form-group">
            <input name="keywords" type="text" class="form-control" style="width: 300px;" placeholder="Job title, keywords, or company name" />
        </div>
        <div class="form-group">
            <input name="location" type="text" class="form-control" style="width: 200px;" placeholder="City, State or Zip code" />
        </div>
        <div class="form-group">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
            <button type="submit" class="btn btn-default">Search</button>
        </div>
    </form>

</div>
@endsection