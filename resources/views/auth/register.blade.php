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
    <style>
        html,body{
            height: 100%;
        }

        .beforeTheForm{
            min-height: 24%;
        }
        .buttons{
            margin-top: 30px;
        }
    </style>

</head>
<body>
<div class="beforeTheForm">
    <h2 class="text-center">RushMid.is</h2>
</div>
<div class="text-center theForm">
    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}

        <div>
            <p><i>Nick Name</i></p>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nick">

        </div>

        <div>
            <p><i>Email</i></p>
            <input type="email" name="email" value="{{ old('email') }}"placeholder="Email">
        </div>

        <div>
            <p><i>Password</i></p>
            <input type="password" name="password" placeholder="Password">
        </div>

        <div>
            <p><i>Confirm Password</i></p>
            <input type="password" name="password_confirmation" placeholder="Password">
        </div>

        <div class="buttons">
            <button type="submit">Register</button> Or <a href="login">Login</a>
        </div>

    </form>
</div>

</body>
</html>
