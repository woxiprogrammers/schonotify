<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    Welcome to Veza, {{$email}} !
    Thanks for signing-up for Veza. Please confirm your email.
    Please follow the link below to verify your email address

    <a href="{{ URL::to('verify/' . $confirmation_code) }}"> Activate account </a>

    Your Email Id : {{$email}}
    Password : {{$password}} <br/>

    Have any questions or feedback? Just contact your administrator.<br/>
    --The Veza Team.<br/>

    This is an automated email, please don’t reply.

</div>

</body>
</html>