
   <select name="caste">
       <option>Select Caste</option>
    @foreach($query as $castes)
    <option id="{{$castes['id']}}" class="form-control castes_list" value="{{$castes['id']}}">{{$castes['caste_category']}}</option>
    @endforeach
   </select>

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
   <script src="/assets/js/form-validation.js"></script>
   <script src="/assets/js/main.js"></script>
   <script src="/assets/js/form-elements.js"></script>
   <script src="/assets/js/custom-project.js"></script>
   <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
   <script src="/assets/js/table-data.js"></script>

   <script>
       jQuery(document).ready(function()
          {
              $("select[name='caste'] option[value='{{$query1}}']").attr("selected", "selected");
          });
   </script>