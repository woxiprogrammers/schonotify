
@foreach($students as $student)

<div id ="myChildrensEdit{!! $student->id !!}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="resetBatch">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">My Children Edit</h4>
            </div>
            <div class="modal-body">

                <form id="formEditAccount" method="post" action="/edit-student/{!! $student->id !!}"  enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Batch</label>
                                    <select class="form-control" name="country" style="-webkit-appearance: menulist;">
                                        <option value=""></option>
                                        <option value="first">First</option>
                                        <option value="second">Second</option>
                                    </select>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select class</label>
                                    <select class="form-control" name="country" style="-webkit-appearance: menulist;">
                                        <option value=""></option>
                                        <option value="first">First</option>
                                        <option value="second">Second</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select division</label>
                                    <select class="form-control" name="country" style="-webkit-appearance: menulist;">
                                        <option value=""></option>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Roll Number</label>
                                    <input type="text" value="{!! $student->roll_number !!}"  class="form-control" id="roll_number" name="roll_number">
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" value="{!! $student->username !!}" readonly class="form-control" id="username" name="username">
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">First name</label>
                                    <input type="text" value="{!! $student->first_name !!}" class="form-control" id="firstname" name="firstname">
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Last name</label>
                                    <input type="text" value="{!! $student->last_name !!}" class="form-control" id="lastname" name="lastname">
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    <input type="email" value="{!! $student->email !!}" class="form-control" id="email" name="email">
                                    <div class="" id="emailfeedback" ></div>
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <input type="text" placeholder="{!! $student->mobile !!}" value="{!! $student->mobile !!}" class="form-control" id="mobile" name="mobile">
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Gender</label>
                                    <div class="clip-radio radio-primary">
                                        <input type="radio" value="F" name="gender" id="us-female" @if($student->gender=="F") checked @endif>
                                        <label for="us-female">Female</label>
                                        <input type="radio" value="M" name="gender" id="us-male" @if($student->gender=="M")checked @endif>
                                        <label for="us-male">Male</label>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <textarea maxlength="250"  id="address" name="address"  class="form-control limited">{!! $student->address !!}</textarea>
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Date of Birth </label>
                                    <div class="input-group input-append datepicker date col-sm-6">
                                        <input type="text" class="form-control" name="DOB" value="{!! $student->birth_date !!}"/>
                                        <span class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </button>
                                         </span>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Alternate number</label>
                                    <input type="text" placeholder="{!! $student->alternate_number !!}" value="{!! $student->alternate_number !!}" class="form-control" id="Alternate_number" name="Alternate_number">
                                    </div>
                                <div class="form-group">
                                    <label>Image Upload</label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail  col-sm-4">
                                            <img src="/uploads/profile-picture/{!! $student->avatar !!}" alt="">
                                            </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail  col-sm-6 pull-right"></div>
                                        <div class="user-edit-image-buttons pull-right col-sm-6">
                                            <span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i>Browse Image</span><span class="fileinput-exists"><i class="fa fa-picture"></i></span>
                       <input type="file" name="avatar">
                    </span>
                                            <a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
                                                <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                    <div class="modal-footer">
                        <button type="button" id="resetBatch1" class="btn btn-primary btn-o" data-dismiss="modal" >
                            Close
                            </button>
                        <button class="btn btn-primary pull-right" type="submit" id="updateUserInfo" >
                            Update <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>
@endforeach