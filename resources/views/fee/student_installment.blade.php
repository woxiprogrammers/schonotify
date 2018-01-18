

<table class="table table-bordered table-hover">
    @if(!empty($installment_data))
    @foreach($installment_data as  $installments)
        @foreach($installments as  $a)
            <tr>
                <td colspan="2" style="text-align: center"><b>structure Name :- {{$a['fee_name']}}</b></td>
            </tr>
          @foreach($a['particulars'] as $data)
            <tr>
                <td style="width: 100px" >{{$data['particular_name']}}</td>
                <td>{{($data['amount'])}}</td>
            </tr>

          @endforeach
        @endforeach
    @endforeach
    @endif
</table>
 @if(!empty($str))
 <h3>{{$str}}</h3>
@endif
