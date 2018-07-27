<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
 
<body>
<h2>Welcome to the site {{$user['display_name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}}

<a href="{{env('APP_URL')}}/registration/{{$user['email']}}/{{$user['uniqid']}}"><input type="button" value="Verify Email" /></a>
<p>

    {{env('APP_URL')}}/registration/{{$user['email']}}/{{$user['uniqid']}}

</p>
</body>
 
</html>