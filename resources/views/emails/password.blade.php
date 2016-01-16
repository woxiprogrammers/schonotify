<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    Hello {{$user->username}},<br/><br/>

    Your Veza account password needs to be changed.<br/>

    Please follow these steps to reset your password. <a href="{{ url('password/reset/'.$token) }}"> Reset your password. </a><br/><br/>

    --The Veza Team.<br/>

    This is an automated email, please don’t reply.<br/>

</div>

</body>
</html>