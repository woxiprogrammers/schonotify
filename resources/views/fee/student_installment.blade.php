

<table class="table table-bordered table-hover">
    @if(!empty($installment_data))
    @foreach($installment_data as  $installments)
    @foreach($installments as $a)
    <tr>
        <td style="width: 100px" style="width: 200px;">{{$a['particulars_name']}}</td>
        <td>{{($a['amount'])}}</td>
    </tr>
    @endforeach
    @endforeach
    @endif
</table>
 @if(!empty($str))
 <h3>{{$str}}</h3>
@endif
