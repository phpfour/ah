<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ActiveHire - @yield('title')</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">ActiveHire</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#about" data-toggle="modal" data-target="#aboutModal">About</a></li>
            </ul>
        </div>
    </nav>
    <div class="container" style="margin-top: 50px;">
        @yield('content')
    </div>
    <!-- Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="aboutModal">About</h4>
                </div>
                <div class="modal-body">
                    <p>This demo has been prepared by the team at <a href="http://infoldersoft.com/">iNFOLDER SOFT</a>.</p>
                    <p><strong>Features:</strong></p>
                    <ul>
                        <li>Laravel 5.1</li>
                        <li>Laravel Elixir with Bower and Gulp support</li>
                        <li>Elasticsearch indexer with batch indexing support</li>
                        <li>Keywords search with all standard operators</li>
                        <li>Partial word match</li>
                        <li>Keyword highlight in result</li>
                        <li>Location auto-complete</li>
                        <li>Geo-location search with flexible radius</li>
                        <li>Search result display with result count, current range and prev/next</li>
                        <li>Job details page</li>
                    </ul>
                    <p><strong>Missing:</strong></p>
                    <ul>
                        <li>Open ended location search</li>
                        <li>Filtering by different parameters</li>
                        <li>Faceted search</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/vendor.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>