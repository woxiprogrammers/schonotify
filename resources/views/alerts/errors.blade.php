@if(Session::has('message-error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" area-lebel="close">
        <span area-hidden="true">&times;</span>
    </button>
    {{ Session::get('message-error') }}
</div>
@endif
@if(Session::has('message-success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" area-lebel="close">
        <span area-hidden="true">&times;</span>
    </button>
    {{ Session::get('message-success') }}
</div>
@endif