<div class="row" style="overflow: scroll">
    <input type="hidden" id="checkSign" name="checkSign">
    <div style="margin-left: 50px "> <strong> TermName : {{ $termName}} </strong></div>
    <table border="1" width="100%" cellpadding="10px" style="text-align: center">
        <tr>
            <th style="text-align: center">Students Roll Number:</th>
            <th style="text-align: center">Students Name:</th>
            @for($i=0 ; $i < count($termDetails) ; $i++)
                <th style="text-align: center">{{$termDetails[$i]['exam_type']}} <input type="checkbox" class="checked_{{$i}}" id="checkbox"></th>
            @endfor
        </tr>
        <tr>
            <th style="text-align: center"></th>
            <th style="text-align: center"></th>
            @foreach($termDetails as $terms)
                <th style="text-align: center">{{$terms['out_of_marks']}}</th>
            @endforeach
        </tr>
        @for($k = 0 ; $k < count($StudentsDetails) ; $k++)
            <tr>
                <input type="hidden" name="details[{{$k}}][student_id]" value="{{$StudentsDetails[$k]['id']}}">
                <th style="text-align: center">{{$StudentsDetails[$k]['roll_no']}}</th>
                <th style="text-align: center">{{$StudentsDetails[$k]['full_name']}}</th>
                @for($i=0 ; $i < count($termDetails) ; $i++)
                    @if(array_key_exists('term_marks',$StudentsDetails[$k]))
                        @for($iterator = 0 ; $iterator < count($StudentsDetails[$k]['term_marks']) ; $iterator++)
                            @if($StudentsDetails[$k]['term_marks'][$iterator]['term_id'] == $termDetails[$i]['id'])
                                <input type="hidden" name="details[{{$k}}][marks_details][{{$i}}][exam_type_id]" value="{{$termDetails[$i]['id']}}">
                                <td style="text-align: center"><input type="number" name="details[{{$k}}][marks_details][{{$i}}][marks_obtain]" value="{{$StudentsDetails[$k]['term_marks'][$iterator]['marks']}}" class="checked_{{$i}}" disabled required></td>
                            @endif
                        @endfor
                    @else
                        <input type="hidden" name="details[{{$k}}][marks_details][{{$i}}][exam_type_id]" value="{{$termDetails[$i]['id']}}">
                        <td><input id="marks" placeholder="Enter Marks" type="number" name="details[{{$k}}][marks_details][{{$i}}][marks_obtain]" class="checked_{{$i}}" disabled required></td>
                    @endif
                @endfor
            </tr>
        @endfor
    </table>
</div>
<br><br>
<div class="row form-group" >
      <div class="col-md-6">
          <label style="color: darkred"  class="control-label pull-left"><p style="font-size: 140%">I have filled all the Marks and it is correct as per my knowledge.</p></label>
      </div>
      <div class="col-md-6">
          <input type="checkbox" class="checkbox checkbox-success checkbox-inline" id="teacher-checkbox">
      </div>
</div>
<div class="row form-group">
    <div class="col-md-12" style="text-align: center">
        <label class="control-label pull-left"><p style="font-size: 130%">Remark:</p></label>
        <input style="text-align: center" class="form-control pull-right" type="text"  name="teacher_remark" placeholder="Remark"  required>
    </div>
</div>
        <script>
            $("document").ready(function(){
                $('input[type = "checkbox"]').change(function() {
                    var classes = $(this).attr("class");
                    console.log(classes);
                    if (($(this).prop('checked')==true)) {
                        $('.'+classes).not('input[type="checkbox"]').each(function(){
                            $(this).prop("disabled", false);
                        })
                    }else {
                        $('.'+classes).not('input[type="checkbox"]').each(function() {
                            $(this).prop("disabled", true);
                        });
                    }
                });
                $('#checkSign').val(0);

            });
            $('#teacher-checkbox').change(function(){

                if($('#teacher-checkbox').is(':checked')){
                    $('#submitButton').attr('disabled',false);
                    $('#checkSign').val(1);
                }else{
                    $('#submitButton').attr('disabled',true);
                    $('#checkSign').val(0);
                }
            });
        </script>

