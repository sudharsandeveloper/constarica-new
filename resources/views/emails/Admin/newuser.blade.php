<!DOCTYPE html>
<html>
<head>
    <title>{{ $mailData['title'] }}</title>
</head>
<style>
    body{
        background-color: green;
        color: white;
    }
</style>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>{{ $mailData['body'] }}</p>

    <p>Username/Email: {{ $mailData['email'] }}</p>
    <p>Password: {{ $mailData['password'] }}</p>
     
    <p>Thank you</p>
</body>
</html>