<html>
    <body>
    afbasdjv
        <form method="POST" action="{{$paymentUrl}}">
            <input type="hidden" name="i" value="{{$i}}">
        </form>
    </body>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function(){
            $("form").submit();
        })
    </script>
</html>