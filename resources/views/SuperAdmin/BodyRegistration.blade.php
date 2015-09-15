
<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'sans-serif';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="">
                <div class="">
                    <h3 class="text-center">Register New Organization</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="">
                        <fieldset>
                            <div class="form-group">
                                <select class="form-control input-lg" name="orgName">
                                    @foreach($arr as $res)

                                    <option value="{{ $res->name  }}"> {{ $res->name  }}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control input-lg" name="body_type">
                                    <option value="School">School</option>
                                    <option value="College">College</option>
                                    <option value="Academy">Academy</option>
                                    <option value="University">University</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-lg" placeholder="Body Name" name="body_name" value="" type="text" required="required">
                            </div>
                            <input type="hidden" name="_registration_type" value="school_reg">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <input class="btn btn-lg btn-primary btn-block" value="Create" type="submit">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>