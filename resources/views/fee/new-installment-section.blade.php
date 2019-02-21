<?php
/**
 * Created by Ameya Joshi.
 * Date: 22/1/18
 * Time: 2:36 PM
 */
$fullPayment = array();
$extraConInFullPay = array();
$casteConcessionAmount = $feeConcessionAmount = $lateFee = $extraConAmount = 0;
$isInstallmentPaid = false;
?>

<fieldset>
    <legend> Installments Details</legend>
        @foreach($installments as $id => $installment)
            <?php
                $extraConForInstallment = 0;
                $casteConcessionAmount += $installment['caste_concession_amount'];
                $feeConcessionAmount +=$installment['fee_concession_amount'];
                $lateFee += $installment['late_fee'];
                if($installment['is_paid'] == true){
                    $isInstallmentPaid = true;
                }
                $stdFeeIds = \App\StudentFee::where('id',$studentFeeId)->select('fee_id','student_id')->first();
                $extraConcession = \App\ExtraConcession::where('fee_id',$stdFeeIds['fee_id'])->where('student_id',$stdFeeIds['student_id'])->where('installment_id',$id)->select('id','label','amount')->get()->toArray();
                if($extraConcession != null){
                    foreach ($extraConcession as $extraCon){
                        $extraConInFullPay[] = array(
                            'label' => $extraCon['label'],
                            'amount' => $extraCon['amount']
                        );
                        $extraConAmount += $extraCon['amount'];
                        $extraConForInstallment += $extraCon['amount'];
                    }
                }
            ?>
            @foreach($installment['particulars'] as $particulars)
                <?php
                    $fullPayment[] = array(
                        $particulars['particulars_name'] => $particulars['amount']
                    );
                ?>
            @endforeach
        @endforeach
        @if($isInstallmentPaid == false)
            <?php
                $finalFullPay = array();
                $total = 0;
                foreach($fullPayment as $fullPaymentPart){
                    foreach($fullPaymentPart as $key => $value){
                        if (isset($finalFullPay[$key]))
                        {
                            $finalFullPay[$key] += $value;
                            $total += $value;
                        }
                        else
                        {
                            $finalFullPay[$key] = $value;
                            $total += $value;
                        }
                    }
                }
                $total = $total - $feeConcessionAmount + $extraConAmount - $casteConcessionAmount;
                if($fullPayConc != null){
                    $total = $total-$fullPayConc['amount'];
                }
            ?>
        <div class="row">
            <div class="col-md-3" style="border:1px solid grey;margin-top: 1%;margin-left: 0.2%; padding-bottom: 10px;">
                <span style="font-size: 20px; margin-left: 25%"> Full Payment </span>
                <table style="margin-top: 5%">
                    @foreach($finalFullPay as $key => $value)
                        <tr>
                            <td style="width: 90%;font-weight: bold">
                                {{$key}}
                            </td>
                            <td>
                                {{$value}}
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
                            {{round($casteConcessionAmount,2)}}
                        </td>
                    </tr>
                    <tr style="width: 95%;">
                        <td style="width: 95%;font-weight: bold">
                            Fees Concession
                            @if($concessionName != '')g
                                ({{$concessionName}})
                            @endif
                        </td>
                        <td>
                            {{round($feeConcessionAmount,2)}}
                        </td>
                    </tr>
                    @if($fullPayConc != null)
                        <tr style="width: 95%;">
                            <td style="width: 95%;font-weight: bold">
                                Full Pay Concession
                            </td>
                            <td>
                                {{($fullPayConc['amount'])}}
                            </td>
                        </tr>
                    @endif
                    @if($extraConInFullPay != null)
                        @foreach($extraConInFullPay as $extraConInFullPays)
                            <tr style="width: 95%;">
                                <td style="width: 95%;font-weight: bold">
                                    {{$extraConInFullPays['label']}}
                                </td>
                                <td>
                                    {{$extraConInFullPays['amount']}}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tr style="width: 95%;">
                        <td style="width: 95%;font-weight: bold">
                            Late fee Amount
                        </td>
                        <td>
                            {{($lateFee)}}
                        </td>
                    </tr>
                </table>
                <hr>
                <table>
                    <tr style="width: 95%;">
                        <td style="width: 95%; color: #0a1115;font-weight: bold">
                            Total
                        </td>
                        <td style="color: #0a1115">
                            {{round($total,2)}}
                        </td>
                    </tr>
                </table>
                <form id="billGeneratorForm_{{$id}}">
                    <input type="hidden" name="slug" value="{{$slug}}">
                    <input type="hidden" value="{{$student['grn']}}" name="student_grn">
                    <input type="hidden" value="{{$id}}" name="installment_id">
                    <input type="hidden" value="{{$student['body_id']}}" name="student_body_id">
                    <input type="hidden" value="{{$student['first_name'].' '.$student['last_name']}}" name="student_name">
                    <input type="hidden" value="{{$student['division']}}" name="section">
                    <input type="hidden" value="{{$student['standard']}}" name="standard">
                    <input type="hidden" value="{{$student['academic_year']}}" name="academic_year">
                    <input type="hidden" value="{{$student['fee_type']}}" name="fee_type">
                    <input type="hidden" value="{{$parent['first_name'].' '.$parent['last_name']}}" name="parent_name">
                    <input type="hidden" value="{{$parent['email']}}" name="email">
                    <input type="hidden" value="{{$parent['mobile']}}" name="contact">
                    <input type="hidden" value="{{round($total,2)}}" name="amount">
                    @if($add_field == false)
                        <button class="btn btn-primary btn-wide" type="button" onclick="submitForm({{$id}})" style="margin-left: 20%; margin-top: 10px">
                            Make Payment
                        </button>
                    @endif
                </form>
            </div>
    @endif
        @foreach($installments as $id => $installment)
            <?php
                $extraConForInstallment = 0;
                $stdFeeIds = \App\StudentFee::where('id',$studentFeeId)->select('fee_id','student_id')->first();
                $extraConcession = \App\ExtraConcession::where('fee_id',$stdFeeIds['fee_id'])->where('student_id',$stdFeeIds['student_id'])->where('installment_id',$id)->select('id','label','amount')->get()->toArray();
                if($extraConcession != null){
                    foreach ($extraConcession as $extraCon){
                        $extraConForInstallment += $extraCon['amount'];
                    }
                }
            ?>
            @if($installment['is_paid'] == true)
                <div class="col-md-3" style="border:1px solid green;margin-top: 1%;margin-left: 0.2%">
            @else
                <div class="col-md-3" style="border:1px solid grey;margin-top: 1%;margin-left: 0.2%; padding-bottom: 10px;">
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
                        @if($concessionName != '')
                            ({{$concessionName}})
                        @endif
                    </td>
                    <td>
                        {{round($installment['fee_concession_amount'],2)}}
                    </td>
                </tr>
                @if($extraConcession != null)
                    @foreach($extraConcession as $extra)
                        <tr style="width: 100%;">
                            <td style="width: 90%;font-weight: bold">
                                {{$extra['label']}}
                            </td>
                            <td>
                                {{$extra['amount']}}
                            </td>
                            @if($isUserAdmin == 1 && $installment['is_paid'] == false)
                                <td class="pull-right" style="width: 2%">
                                    <button type="button" class="close" aria-label="Close" onclick="removeField({{$extra['id']}})">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                <tr style="width: 95%;">
                    <td style="width: 95%;font-weight: bold">
                        Late fee Amount
                    </td>
                    <td>
                        {{($installment['late_fee'])}}
                    </td>
                </tr>
            </table>
            <hr>
            <table>
                <tr style="width: 95%;">
                    <td style="width: 95%; color: #0a1115 ;font-weight: bold">
                        Total
                    </td>
                    <td style="color: #0a1115">
                        {{round($installment['final_total'] + $extraConForInstallment,2)}}
                    </td>
                </tr>
            </table>
                    <div id="add{{$id}}"></div>
                @if($installment['is_paid'] == false)
                    <form id="billGeneratorForm_{{$id}}">
                        <input type="hidden" name="slug" value="{{$slug}}">
                        <input type="hidden" value="{{$student['grn']}}" name="student_grn">
                        <input type="hidden" value="{{$id}}" name="installment_id">
                        <input type="hidden" value="{{$student['body_id']}}" name="student_body_id">
                        <input type="hidden" value="{{$student['first_name'].' '.$student['last_name']}}" name="student_name">
                        <input type="hidden" value="{{$student['division']}}" name="section">
                        <input type="hidden" value="{{$student['standard']}}" name="standard">
                        <input type="hidden" value="{{$student['academic_year']}}" name="academic_year">
                        <input type="hidden" value="{{$student['fee_type']}}" name="fee_type">
                        <input type="hidden" value="{{$parent['first_name'].' '.$parent['last_name']}}" name="parent_name">
                        <input type="hidden" value="{{$parent['email']}}" name="email">
                        <input type="hidden" value="{{$parent['mobile']}}" name="contact">
                        <input type="hidden" value="{{round($installment['final_total'],2)}}" name="amount">
                        <input type="hidden" value="{{$studentFeeId}}" name="std">
                        @if($add_field == false)
                        <button class="btn btn-primary btn-wide" type="button" onclick="submitForm({{$id}})" style="margin-left: 20%; margin-top: 10px">
                            Make Payment
                        </button>
                        @endif
                    </form>
                @endif
                    @if($installment['is_paid'] == false && $add_field == true)
                        <button class="btn btn-primary btn-wide" type="button" onclick="addField('{{$id}}','{{$studentFeeId}}')" style="margin-left: 20%; margin-top: 10px">
                            Add Field
                        </button>
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
                    <form id="paymentForm" method="post">
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
    function addField(id,stdfee) {
        $("#add"+id).append('<tr>'+'<td>'+
            '<input type="text" style="width: 90px; font-size: 12px; font: bold" name="addField['+id+'][label][]" placeholder="Enter Label" required>'+'</td>'+
            '<td>'+'<input type="number" style="width: 90px; font-size: 12px; font: bold" name="addField['+id+'][amount][]" placeholder="Amount" required>'+'</td>'+
        '</tr>'+'<br>'+'<input type="hidden" value="'+stdfee+'" name="student_fee_id">')
    }
    function removeField(id) {
            if (confirm("Delete Concession! are you sure ?")) {
                var route = '/delete-extra-concession/' + id;
                $.get(route, function () {
                    window.location.replace(route);
                });
            }
    }
    function submitForm(id){

        var formData = $("#billGeneratorForm_"+id).serializeArray();
        $.ajax({
            url: '/payment/make-payment',
            data: formData,
            type: 'POST',
            async: true,
            success: function(data,testStatus,xhr){
                $("#paymentForm").attr('action',data.payment_url);
                $("#paymentForm input").val(data.i);
                $("#confirm-statement h4").html("Payable Amount:"+data.amount+"<br>Do you want to continue payment?");
                $("#confirm-payment").modal('show');
            },
            error: function(data, errStatus){
            }
        });
    }
</script>
