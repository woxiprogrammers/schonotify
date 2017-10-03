
@foreach($termDetails1 as $value)
<tr>
    <th></th>
    <th>Exam Type</th>
    <th>
    @foreach($termDetails as $value1)
        <input type="text" value="{!! $value1['exam_type']!!}" readonly>
    @endforeach
    </th>
</tr>
    <tr>
        <td rowspan="2">
            <input type="text" value="{!!$value['term_name']!!}" readonly>
        </td>
        <td>

        </td>
    </tr>
<tr>
    <td>out-Of-Marks</td>
    <td>
        @foreach($termDetails as $value1)
         <input type="text" value="{!!  $value1['out_of_marks']!!}" readonly>
        @endforeach
    </td>
</tr>
@endforeach
