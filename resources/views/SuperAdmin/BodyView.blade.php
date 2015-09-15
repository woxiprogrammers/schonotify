
<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <style>
        body{
            font-family: 'sans-serif';
        }
    </style>
</head>
<body>
<div class="container">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="">

                <div class="panel-body">
                    <pre>
                    @foreach($newArr as $row)
                     {{ $row }}
                    @endforeach
                    </pre>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>