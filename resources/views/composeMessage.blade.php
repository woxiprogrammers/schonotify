<div id ="compose-msg" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="resetBatch">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Compose Message</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Select User Role
                            </label>
                            <select class="form-control" name="userRole" style="-webkit-appearance: menulist;" id="user-role">
                            </select>
                        </div>
                    </div>
                </div>
                <form id="compose-message-admin" role="form" method="post" action="compose-message">
                    <div class="row" id="for-admin">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                    Select Admin
                                </label>
                                <select class="form-control" name="user_id" style="-webkit-appearance: menulist;" id="admin-list">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="msg-description">
                        <div class="row" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Message
                                    </label>
                                    <input type="text" placeholder="Enter Text Message Here" class="form-control" name="description"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="resetBatch1" class="btn btn-primary btn-o" data-dismiss="modal" >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Send
                        </button>
                    </div>
                </form>
                <form method="post" action="compose-message" role="form" id="compose-message-teacher">


                    <div class="row" id="for-teacher">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                    Select Teacher
                                </label>
                                <select class="form-control" name="user_id" style="-webkit-appearance: menulist;" id="teacher-list">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="msg-description">
                        <div class="row" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Message
                                    </label>
                                    <textarea class="form-control" placeholder="Enter Text Message Here" name="description">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="resetBatch1" class="btn btn-primary btn-o" data-dismiss="modal" >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Send
                        </button>
                    </div>
                </form>
                <form method="post" action="compose-message" role="form" id="compose-message-student">

                    <div id="for-student">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Select Batch
                                    </label>
                                    <select class="form-control" name="batch" style="-webkit-appearance: menulist;" id="msgbatch">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Select class
                                    </label>
                                    <select class="form-control" name="class" style="-webkit-appearance: menulist;" id="msgclass">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Select division
                                    </label>
                                    <select class="form-control" name="division" style="-webkit-appearance: menulist;" id="msgdivision">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Select Student
                                    </label>
                                    <select class="form-control" name="user_id" style="-webkit-appearance: menulist;" id="student-list">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="msg-description">
                        <div class="row" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Message
                                    </label>
                                    <textarea class="form-control" placeholder="Enter Text Message Here" name="description">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="resetBatch1" class="btn btn-primary btn-o" data-dismiss="modal" >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Send
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>