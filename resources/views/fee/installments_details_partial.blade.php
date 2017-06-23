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
            <div class="col-md-3" style="border:2px solid black;margin-top: 1%;margin-left: 0.2%">
        @else
            <div class="col-md-3" style="margin-top: 1%;margin-left: 0.2%; padding-bottom: 10px;">
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
            <hr>
                    <table style="margin-top: 10%;width: 95%;">
                        <tr style="width: 95%;">
                            <td style="width: 95%;font-weight: bold">
                                Caste Concession
                            </td>
                            <td>
                                {{round($installment['caste_concession_amount'],2)}}
                            </td>
                        </tr>
                        <tr style="width: 95%;">
                            <td style="width: 95%;font-weight: bold">
                                Fees Concession
                            </td>
                            <td>
                                {{round($installment['fee_concession_amount'],2)}}
                            </td>
                        </tr>
                        <tr style="width: 95%;">
                            <td style="width: 95%;font-weight: bold">
                                Total
                            </td>
                            <td>
                                {{round($installment['final_total'],2)}}
                            </td>
                        </tr>
                    </table>
                @if($installment['is_paid'] == false)
                    <form id="billGeneratorForm_{{$id}}">
                        <input type="hidden" value="{{$student['grn']}}" name="student_grn">
                        <input type="hidden" value="{{$student['body_id']}}" name="student_body_id">
                        <input type="hidden" value="{{$student['first_name'].' '.$student['last_name']}}" name="student_name">
                        <input type="hidden" value="{{$student['division']}}" name="section">
                        <input type="hidden" value="{{$student['standard']}}" name="standard">
                        <input type="hidden" value="{{$student['academic_year']}}" name="academic_year">
                        <input type="hidden" value="{{$student['fee_type']}}" name="fee_type">
                        <input type="hidden" value="{{$parent['first_name'].' '.$parent['last_name']}}" name="parent_name">
                        <input type="hidden" value="{{$parent['first_name']}}" name="email">
                        <input type="hidden" value="{{$parent['mobile']}}" name="contact">
                        <input type="hidden" value="{{round($installment['final_total'],2)}}" name="amount">
                        <button class="btn btn-primary btn-wide" type="button" onclick="submitForm({{$id}})" style="margin-left: 20%; margin-top: 10px">
                            Make Payment
                        </button>
                    </form>
                @endif
        </div>

                @endforeach
    </div>
  </div>
</fieldset>
<!--Student GRN No.|Student Name|Section|Standard|Academic Year|Fee Type|Parents Name|Email|Contact Number|Amount-->
<div id ="confirm-payment" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="resetBatch">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="myModalLabel">Confirm Payment</h3>
            </div>
            <div class="modal-body row">
                <div class="col-md-8">
                    <span id="confirm-statement"> <h4>  </h4> </span>
                    <form id="paymentForm" method="post" action="{{env('EASY_PAY_PAYMENT_URL')}}">
                        <input name="i" type="hidden">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <button class="btn btn-primary form-control" id="confirm"> Confirm </button>
                            </div>
                            <div class="col-md-4">
                                <a href="javascript:void(0);" class="btn btn-warn form-control" data-dismiss="modal">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function submitForm(id){
        var formData = $("#billGeneratorForm_"+id).serializeArray();
        $.ajax({
            url: '/payment/make-payment',
            data: formData,
            type: 'POST',
            async: true,
            success: function(data,testStatus,xhr){
                $("#paymentForm input").val(data.i);
                $("#confirm-statement h4").html("Payable Amount:"+data.amount+"<br>Do you want to continue payment?");
                $("#confirm-payment").modal('show');
            },
            error: function(data, errStatus){

            }
        });
    }
</script>
