
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
            @if($all[$i]['status'] == 1)
            <td><input type="checkbox" onchange="publish(this)" value="{{$all[$i]['exam_structure_id']}}" class="admin-check" checked></td>
            @else
               <td><input type="checkbox" onchange="publish(this)" value="{{$all[$i]['exam_structure_id']}}" class="admin-check"></td>
            @endif
                @else
                <td><input type="checkbox"></td>
            @endif
            <td><input style="text-align: center" type="text" class="form-control" id="name" name="subject_name[]" value="{{$all[$i]['sub_subject_name']}}" readonly></td>
                @if(array_key_exists('check_sign',$all[$i]))
                    <td><input type="checkbox" id="teacher-sign" checked="checked" class="teacher_sign" disabled></td>
                    <td><input style="text-align: center" type="text" class="form-control" id="remark" name="remark[]" value="{{$all[$i]['remark']}}" readonly></td>
                    @if(array_key_exists('status',$all[$i]) && $all[$i]['status'] == 1)
                        <td><input type="text" readonly="readonly" placeholder="published"></td>
                        @else
                         <td><input type="text" readonly="readonly" placeholder="Un-published"></td>
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
    function publish(element){
        if(element.checked){
            var publishStatus = '1';
        }else{
            var publishStatus = '0';
        }
        var subSubjectId = element.value;
        var class_id =$('#class-select').val();
        $.ajax({
            url:'/exam/admin-publish-model',
            type: "POST",
            data: {
                classId:class_id,
                publishStatus: publishStatus,
                sub_subject_id: subSubjectId
            },
            success:function(data,textStatus,xhr){
                if(publishStatus == 1){
                    swal({
                        title: "Published!",
                        text: "Result will be Updated to Parents !",
                        type: "success",
                        confirmButtonColor : ["green", setTimeout(function () {
                            location.reload()
                        }, 1150)],
                        closeOnCancel: false
                    });
                }else{
                    swal({
                        title: "Un-Published!",
                        text: "Result Will be Not Updated to Parents !",
                        type: "error",
                        confirmButtonColor:["#DD6B55", setTimeout(function () {
                            location.reload()
                        }, 1150)] ,
                        closeOnCancel: false
                    });
                }
            },
            error:function(errorData){
                alert(errorData)
            }
        })
    }
</script>
<br><br>