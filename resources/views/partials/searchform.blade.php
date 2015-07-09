<div class="row">

    <div class="col-md-12 text-center">
        <form class="form-inline" role="form" method="post">
            <div class="form-group">
                <input name="keywords" type="text" value="{{ $post['keywords'] or '' }}"
                    class="form-control" style="width: 300px;" placeholder="Job title, keywords, or company name" />
            </div>
            <div class="form-group">
                <input name="location" type="text" value="{{ $post['location'] or '' }}"
                    class="form-control" style="width: 200px;" placeholder="City, State or Zip code" />
            </div>
            <div class="form-group">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                <button type="submit" class="btn btn-default">Search</button>
            </div>
        </form>
    </div>

</div>