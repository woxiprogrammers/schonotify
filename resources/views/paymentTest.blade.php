<html>
    <body>
        <form method="POST" action="{{$paymentUrl}}">
            <input type="hidden" name="i" value="{{$i}}">
            <input type="submit" value="Submit">
        </form>
    </body>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
//            $("form").submit();
        })
    </script>
</html>