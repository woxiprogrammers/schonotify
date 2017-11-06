<br><br>
<input type="hidden" id="checkedSign" name="checkedSign">
<div class="row" >
<table border="1" width="100%" cellpadding="10px" style="text-align: center">
<tr>
    <th></th>
    <th style="text-align: center">Sub-Subject Name</th>
    <th style="text-align: center">Teacher Signature</th>
    <th style="text-align: center">Remark</th>
</tr>
    @if(count($teacherInfo)>0)
    @foreach($teacherInfo as $details)
        <tr>
            <input type="hidden" name="sub_subject[]" value="{{$details['exam_structure_id']}}">
            <td><input type="checkbox" class="admin-check"></td>
            <td><input style="text-align: center" type="text" class="form-control" id="name" name="subject_name[]" value="{{$details['sub_subject_name']}}" readonly></td>
                @if($details['check_sign'] == 1)
                    <td><input type="checkbox" checked value="checked" readonly></td>
                    <td><input style="text-align: center" type="text" class="form-control" id="remark" name="remark[]" value="{{$details['remark']}}" readonly></td>
                @endif
            </tr>
    @endforeach
        @else
            @for($i=0 ; $i < count($subSubject) ; $i++)
                <tr>
                    <td><input type="checkbox"></td>
                    <td><input style="text-align: center" type="text" class="form-control" id="name" value="{{$subSubject[$i]['sub_subject_name']}}" readonly></td>
                    <td><input type="checkbox"></td>
                    <td><input type="text" readonly></td>
                </tr>
            @endfor
        @endif
</table>
</div>
<script>
    $('.admin-check').change(function(){
        if($('.admin-check').is(':checked')){
            $('#publishButton').attr('disabled',false);
            $('#UnpublishButton').attr('disabled',false);
            $('#checkedSign').val(1);
        }else{
            $('#publishButton').attr('disabled',true);
            $('#UnpublishButton').attr('disabled',true);
            $('#checkedSign').val(0);
        }
    });
</script>
<br><br>