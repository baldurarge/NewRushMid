<!doctype html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>RushMid</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

    <!-- MY Stuff -->
    <link rel="stylesheet" href="css/mycss.css">

</head>
<body>
<div class="theMainContent">
    <div class="col-lg-2 sideBarLeft text-left">
        <nav class="nav-sidebar">
            <ul class="nav">
                <li class=""><a href="home"><h4><i class="glyphicon glyphicon-home"></i> Home</h4></a></li>
                <li class="nav-divider"></li>
                <li><a href=""><h4><i class="glyphicon glyphicon-user"></i> MyProfile</h4></a></li>
                <li class="nav-divider"></li>
                <li><a href="auth/logout"><h4><i class="glyphicon glyphicon-off"></i> Sign Out</h4></a></li>
            </ul>
        </nav>
    </div>
    <div class="col-lg-8 text-center">
        @yield('content')
    </div>
    <div class="col-lg-2 text-right">
        <nav class="nav-sidebar">
            <ul class="nav">
                @yield('friendsList')
            </ul>
        </nav>
    </div>
</div>


<div class="col-lg-12 theFooter text-center">
    <div class="footer-content">
        <h3>RushMid.is is trademark of Baldur Arge Sveinsson</h3>
        <h4>Copyright © Baldur Arge</h4>
    </div>
</div>
</body>
@yield('theJavaScript')
</html>