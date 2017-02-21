                <table style="width:100%" border="1">

                    <tr>

                        <th>Particulars</th>
                        @foreach($installment_details as $installment_inputs)
                        <th>Installmest{{$installment_inputs['id']}}</th>
                        @endforeach



                    </tr>
                    @foreach($fee_particulars as $particulars)
                    <tr>
                         <td>  <label for="{{ $particulars['id'] }}">{{ $particulars['particular_name'] }}</label></td>
                        @foreach($installment_details as $installment_inputs)
                         <td>  <input class="{{ $installment_inputs['id'] }}" type="text"   name="installment[{{ $installment_inputs['id'] }}][{{ $particulars['id'] }}]" id="{{ $particulars['id'] }}{{ $installment_inputs['id'] }}">  </td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr>
                       <td>Total amount of installment</td>
                        @foreach($installment_details as $installment_inputs)
                        <td>  <input type="text" class="a" id="{{ $installment_inputs['id'] }}_sum_id" name="inputv[]"> </td>
                        @endforeach

                    </tr>

                </table>


                <script src="/vendor/jquery/jquery.min.js"></script>
                <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
                <script src="/vendor/modernizr/modernizr.js"></script>
                <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
                <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
                <script src="/vendor/switchery/switchery.min.js"></script>
                <!-- end: MAIN JAVASCRIPTS -->
                <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
                <script src="/vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
                <script src="/vendor/ckeditor/ckeditor.js"></script>
                <script src="/vendor/ckeditor/adapters/jquery.js"></script>
                <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
                <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
                <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
                <!-- start: CLIP-TWO JAVASCRIPTS -->
                <script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
                <script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
                <script src="/vendor/autosize/autosize.min.js"></script>
                <script src="/vendor/selectFx/classie.js"></script>
                <script src="/vendor/selectFx/selectFx.js"></script>
                <script src="/vendor/select2/select2.min.js"></script>
                <script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
                <script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

                <!-- start: JavaScript Event Handlers for this page -->

                <script src="/assets/js/form-validation-edit.js"></script>
                <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>

                <script src="/assets/js/main.js"></script>
                <script src="/assets/js/form-elements.js"></script>
                <script src="/assets/js/custom-project.js"></script>
                <script src="/assets/js/table-data.js"></script>
                <script>

                    $(document).ready(function() {
                        var intaa ;
                        //this calculates values automatically
//                        calculateSum();





                        $(".1").on("keydown keyup", function() {
                            calculateSum();



                        });
                        $(".2").on("keydown keyup", function() {
                            calculateSum2();

                        });
                        $(".3").on("keydown keyup", function() {
                            calculateSum3();

                        });
                        $(".4").on("keydown keyup", function() {
                            calculateSum4();

                        });
                        $(".5").on("keydown keyup", function() {
                            calculateSum5();

                        });
                   function addition()
                   {

                       var l=parseInt($("#1_sum_id").val());
                       var m=parseInt($("#2_sum_id").val());
                       var n=parseInt($("#3_sum_id").val(),10);
                       var o=parseInt($("#4_sum_id").val(),10);
                       var p=parseInt($("#5_sum_id").val(),10);

                       var inst_count=$("#inst_no").val();

                           if(inst_count == 1)
                               {

                                  var a=l;
                                  $("#total_fee").val(a);
                               }
                           else if(inst_count == 2)
                               {

                                  var a=l+m;
                                  $("#total_fee").val(a);

                               }
                           else if(inst_count == 3)
                               {

                                  var a=l+m+n;
                                  $("#total_fee").val(a);

                               }
                           else if(inst_count == 4)
                               {

                                  var a=l+m+n+o;
                                  $("#total_fee").val(a);
                               }
                           else
                               {

                                  var a=l+m+n+o+p;
                                  $("#total_fee").val(a);

                                }
                   }




                    function calculateSum(inta) {


                    //    console.log(intaa);

                        var sum = 0;
                        //iterate through each textboxes and add the values
                        $(".1").each(function() {
                            //add only if the value is number
                            if (!isNaN(this.value) && this.value.length != 0) {
                                sum += parseFloat(this.value);
                                $(this).css("background-color", "#FEFFB0");
                            }
                            else if (this.value.length != 0){
                                $(this).css("background-color", "red");
                            }
                        });

                        $("input#1_sum_id").val(sum.toFixed(2));
                          var inta=sum;
                       // console.log(inta);
                        addition();


                    }
                    function calculateSum2(intaa) {

                      //  console.log(inta);

                        var sum = 0;
                        //iterate through each textboxes and add the values
                        $(".2").each(function() {
                            //add only if the value is number
                            if (!isNaN(this.value) && this.value.length != 0) {
                                sum += parseFloat(this.value);
                                $(this).css("background-color", "#FEFFB0");
                            }
                            else if (this.value.length != 0){
                                $(this).css("background-color", "red");
                            }
                        });

                        $("input#2_sum_id").val(sum.toFixed(2));


                        addition();
                    }
                    function calculateSum3() {



                        var sum = 0;
                        //iterate through each textboxes and add the values
                        $(".3").each(function() {
                            //add only if the value is number
                            if (!isNaN(this.value) && this.value.length != 0) {
                                sum += parseFloat(this.value);
                                $(this).css("background-color", "#FEFFB0");
                            }
                            else if (this.value.length != 0){
                                $(this).css("background-color", "red");
                            }
                        });

                        $("input#3_sum_id").val(sum.toFixed(2));
                        addition();
                    }
                    function calculateSum4() {



                        var sum = 0;
                        //iterate through each textboxes and add the values
                        $(".4").each(function() {
                            //add only if the value is number
                            if (!isNaN(this.value) && this.value.length != 0) {
                                sum += parseFloat(this.value);
                                $(this).css("background-color", "#FEFFB0");
                            }
                            else if (this.value.length != 0){
                                $(this).css("background-color", "red");
                            }
                        });

                        $("input#4_sum_id").val(sum.toFixed(2));
                        addition();
                    }
                    function calculateSum5() {



                        var sum = 0;
                        //iterate through each textboxes and add the values
                        $(".5").each(function() {
                            //add only if the value is number
                            if (!isNaN(this.value) && this.value.length != 0) {
                                sum += parseFloat(this.value);
                                $(this).css("background-color", "#FEFFB0");
                            }
                            else if (this.value.length != 0){
                                $(this).css("background-color", "red");
                            }
                        });

                        $("input#5_sum_id").val(sum.toFixed(2));
                        addition();
                    }
                    });

                </script>
