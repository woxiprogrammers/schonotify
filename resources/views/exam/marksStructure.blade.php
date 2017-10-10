<div style="overflow: scroll">
    @foreach($student as $key=> $studnt)
    {{dd($studnt)}}
        Name:<input type="text" size="8%" value="{{$key}}" readonly>
    <table border=1 id="table1" width="100%" cellpadding="10" cellspacing="10">
        @foreach($detail as $key => $value)
        <tr>
            <th></th>
            <th style="padding: 10px;">Exam Type</th>
            @foreach($value as $data)
                <th style="padding: 10px;">{{$data['exam_type']}}</th>
            @endforeach
        </tr>
            <tr>
                <td rowspan="2" style="padding: 10px">{{$key}}</td>
                <td style="padding: 10px;">marks</td>
                @foreach($value as $item)
                <td><input type="text" id="marks[]"></td>
                @endforeach
            </tr>
            <tr>
                <td style="padding: 10px;">Out Of Marks</td>
                @foreach($value as $data)
                <td style="padding: 10px;">{{$data['out_of_marks']}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
        @endforeach
</div>
