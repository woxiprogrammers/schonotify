@foreach($termName as $value)
    <tr>
    <th></th>
    <th>
            @foreach($termDetails as $value1)
                {{$value1['exam_type']}}
                @endforeach
    </th>
</tr>
    <tr>
        <td rowspan="2">
            {{$value['term_name']}}
        </td>
        <td>
            marks
        </td>
    </tr>
<tr>
    <td>
        @foreach(explode(',', $value1->out_of_marks) as $string)
            {{ $string }}
            @endforeach
        </td>
        @endforeach
    </tr>
