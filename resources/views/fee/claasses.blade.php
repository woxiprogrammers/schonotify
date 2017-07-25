<select class="form-control" name="class" id="classesDropdowntable" style="-webkit-appearance: menulist;">
    <option>Select Class...</option>
    @foreach($classes as $class)
    <option value={{$class['id']}}>{{$class['class_name']}}</option>
    @endforeach
</select>





<script>
    $( "#classesDropdowntable" )
        .change(function () {

            $str=this.value
            var str = this.value;
            $.ajax({
                url: "/fees/feeListingTable",
                data:{str1 : str},
                success: function(response)
                {
                    $("#feetable").html(response);
                }
            });



        })

</script>
