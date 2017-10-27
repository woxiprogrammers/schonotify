<br><br>
<div class="row" >
<table border="1" width="100%" cellpadding="10px" style="text-align: center">
<tr>
    <th></th>
    <th style="text-align: center">Sub-Subject Name</th>
    <th style="text-align: center">Teacher Signature</th>
    <th style="text-align: center">Remark</th>
</tr>
@foreach($subSubject as $name)
<tr>
    <td><input type="checkbox"></td>
    <td>{{$name['sub_subject_name']}}</td>
    @foreach($teacherInfo as $teacher)
       @if($teacher['check_sign'] == 0)
           <td><input type="checkbox"></td>
           @else
           <td><input type="checkbox" checked></td>
       @endif
       <td>{{$teacher['remark']}}</td>
    @endforeach
</tr>
@endforeach
</table>
</div>
<br><br>