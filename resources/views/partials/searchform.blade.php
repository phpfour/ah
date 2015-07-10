<div class="row">

    <div class="col-md-12 well" style="margin-bottom: 20px;">
        <h4>Search Job</h4>

        <form action="/search" class="form-inline" role="form" method="get">
            <div class="form-group">
                <input name="keywords" type="text" value="{{ $post['keywords'] or '' }}"
                    class="form-control" style="width: 300px;" placeholder="Job title, keywords, or company name" />
            </div>
            <div class="form-group">
                <input name="location" type="text" value="{{ $post['location'] or '' }}"
                    class="form-control typeahead" style="width: 200px;" placeholder="City, State or Zip code" autocomplete="off" />
            </div>
            <div class="form-group">
                <select name="radius" class="form-control">
                    <option value="5" @if (isset($post['radius']) and $post['radius'] == '5') selected @endif>5 miles</option>
                    <option value="10" @if (isset($post['radius']) and $post['radius'] == '10') selected @endif>10 miles</option>
                    <option value="25" @if (isset($post['radius']) and $post['radius'] == '25') selected @endif>25 miles</option>
                    <option value="50" @if (isset($post['radius']) and $post['radius'] == '50') selected @endif>50 miles</option>
                    <option value="100" @if (isset($post['radius']) and $post['radius'] == '100') selected @endif>100 miles</option>
                    <option value="250" @if (isset($post['radius']) and $post['radius'] == '250') selected @endif>250 miles</option>
                    <option value="500" @if (isset($post['radius']) and $post['radius'] == '500') selected @endif>500 miles</option>
                </select>
            </div>
            <div class="form-group">
                <input id="location_id" name="location_id" type="hidden" value="{{ $post['location_id'] or '' }}" />
                <button type="submit" class="btn btn-default">Search</button>
            </div>
        </form>
    </div>

</div>