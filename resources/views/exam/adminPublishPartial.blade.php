<br><br>
<input type="hidden" id="checkedSign" name="checkedSign">
<div class="row" >
<table border="1" width="100%" cellpadding="10px" style="text-align: center">
<tr>
    <th></th>
    <th style="text-align: center">Sub-Subject Name</th>
    <th style="text-align: center">Teacher Signature</th>
    <th style="text-align: center">Remark</th>
    <th style="text-align: center">Status</th>
</tr>
    @for($i=0 ; $i < count($all) ; $i++)
        <tr>
            @if(array_key_exists('exam_structure_id',$all[$i]))
            <input type="hidden" name="sub_subject[]" value="{{$all[$i]['exam_structure_id']}}">
            @endif
            <td><input type="checkbox" class="admin-check"></td>
            <td><input style="text-align: center" type="text" class="form-control" id="name" name="subject_name[]" value="{{$all[$i]['sub_subject_name']}}" readonly></td>
                @if(array_key_exists('check_sign',$all[$i]))
                    <td><input type="checkbox" id="teacher-sign" checked="checked" class="teacher_sign" disabled></td>
                    <td><input style="text-align: center" type="text" class="form-control" id="remark" name="remark[]" value="{{$all[$i]['remark']}}" readonly></td>
                    @if(array_key_exists('status',$all[$i]) && $all[$i]['status'] == 1)
                        <td><input type="text" readonly="readonly" placeholder="puslished"></td>
                        @elseif(array_key_exists('status',$all[$i]) && $all[$i]['status'] == 0)
                             <td><input type="text" readonly="readonly" placeholder="Un-puslished"></td>
                        @else
                        <td><input type="text" placeholder="teacher Checked"></td>
                    @endif
                @else
                    <td><input type="checkbox" id="teacher-sign" class="teacher_sign" disabled></td>
                    <td><input style="text-align: center" type="text" class="form-control" id="remark" name="remark[]" readonly></td>
                @endif
            </tr>
    @endfor
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