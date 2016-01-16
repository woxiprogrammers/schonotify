<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Update User Info</h2>

<div>
    Your Email-Id changed to {{$email}}.
    Please Click on link to Update Account.
    {{ URL::to('verify/' . $confirmation_code) }}.<br/>

    You can login with your old password.<br/>
    --The Veza Team.<br/>

    This is an automated email, please don’t reply.

</div>

</body>
</html>