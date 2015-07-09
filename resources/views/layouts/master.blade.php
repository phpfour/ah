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
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">ActiveHire</a>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 50px;">
        @yield('content')
    </div>
    <script src="/js/vendor.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>