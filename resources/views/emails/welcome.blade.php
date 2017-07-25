<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    Welcome to Veza, {{$email}} !<br/><br/>
    Thanks for signing-up for Veza. Please confirm your email.<br/><br/>
    Please follow the link below to verify your email address<br/><br/>

    <a href="{{ URL::to('verify/' . $confirmation_code) }}"> Activate account </a><br/><br/>

    Your Email Id : {{$email}}<br/>
    Password : {{$password}} <br/>

    Have any questions or feedback? Just contact your administrator.<br/>
    --The Veza Team.<br/><br/>

    This is an automated email, please don’t reply.

</div>

</body>
</html>