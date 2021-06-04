<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h2>Welcome to our website, {{ $user->name }}</h2>
        <p> click <a href="{{ route('user.verify',$user->verifyUser->token) }}">here</a> to verify you email </p>
        
    </body>
</html>