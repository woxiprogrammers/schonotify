<fieldset>
    <input type="hidden" id="slug" value="{{$slug}}">
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
    <legend> Fee Structures: </legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Fee Structure: <span class="symbol required"></span>
                </label>
                <select id="fee_structure_select" class="form-control">
                    @foreach($studentFeeStructures as $studentFeeStructure)
                        <option value="{{$studentFeeStructure['student_fee_id']}}"> {{$studentFeeStructure['fee_name']}} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</fieldset>
<div id="installment_section">

</div>
<script>
    $(document).ready(function(){
        $("#fee_structure_select").on('change', function(){
            var studentFeeId = $(this).val();
            $.ajax({
                url: '/fees/get-structure-installments/'+studentFeeId,
                type: 'POST',
                data:{
                    slug: $("#slug").val()
                },
                success: function(data, textStatus, xhr){
                    $("#installment_section").html(data);
                },
                error: function(errorData){
                    alert('Something went wrong !');
                }
            });
        });

        $("#fee_structure_select").trigger('change');
    });
</script>
