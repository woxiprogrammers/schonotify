<fieldset>
    <legend>Student Details</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Student's First Name:
                </label>
                <input class="form-control" value="{{$student['first_name']}}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Student's Last Name:
                </label>
                <input class="form-control" value="{{$student['last_name']}}" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Parent's First Name:
                </label>
                <input class="form-control" value="{{$parent['first_name']}}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Parent's Last Name:
                </label>
                <input class="form-control" value="{{$parent['last_name']}}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Parent's Email Address:
                </label>
                <input class="form-control" value="{{$parent['email']}}" readonly>
            </div>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend> Installments Details</legend>
    <div class="row">
        @foreach($installments as $id => $installment)
        @if($installment['is_paid'] == true)
            <div class="col-md-2" style="width: 19%;border: 1px solid #46AF18;margin-top: 1%;margin-left: 0.2%">
        @else
            <div class="col-md-2" style="width: 19%;border: 1px solid #000000;margin-top: 1%;margin-left: 0.2%">
        @endif
            <span style="font-size: 20px; margin-left: 25%"> Installment {{$id}}</span>
            <table style="margin-top: 5%">
                @foreach($installment['particulars'] as $particulars)
                        <tr>
                            <td style="width: 90%;font-weight: bold">
                                {{$particulars['particulars_name']}}
                            </td>
                            <td>
                                {{$particulars['amount']}}
                            </td>
                        </tr>
                @endforeach
            </table>
                    <table style="margin-top: 10%">
                        <tr>
                            <td style="width: 95%;font-weight: bold">
                                Caste Concession
                            </td>
                            <td>
                                {{round($installment['caste_concession_amount'],2)}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 95%;font-weight: bold">
                                Fees Concession
                            </td>
                            <td>
                                {{round($installment['fee_concession_amount'],2)}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 95%;font-weight: bold">
                                Total
                            </td>
                            <td>
                                {{round($installment['final_total'],2)}}
                            </td>
                        </tr>
                    </table>
        </div>
        @endforeach

    </div>
</fieldset>
<!--Student GRN No.|Student Name|Section|Standard|Academic Year|Fee Type|Parents Name|Email|Contact Number|Amount-->
<form action="/payment/make-payment" method="POST">
    <div class="col-md-offset-4 col-md-2">
        <input type="hidden" value="" name="student_grn">
        <input type="hidden" value="{{$student['first_name'].' '.$student['last_name']}}" name="student_name">
        <input type="hidden" value="" name="section">
        <input type="hidden" value="" name="standard">
        <input type="hidden" value="" name="academic_year">
        <input type="hidden" value="" name="fee_type">
        <input type="hidden" value="{{$parent['first_name'].' '.$parent['last_name']}}" name="parent_name">
        <input type="hidden" value="{{$parent['first_name']}}" name="email">
        <input type="hidden" value="{{$parent['mobile']}}" name="contact">
        <input type="hidden" value="{{$payableAmount}}" name="amount">
        <button class="btn btn-primary btn-wide form-control" type="submit">
            Make Payment
        </button>
    </div>
</form>