
<div>
    <div class="panel panel-transparent">

        <div class="panel-body">
                <div class="form-group">
                    <label for="form-field-select-2">
                        Select User Roles
                    </label>
                    <select class="form-control" id="role-select" style="-webkit-appearance: menulist;">
                        @if(Auth::user()->role_id == 1)
                        @foreach($userRoles as $roles)

                        <option value="{!! $roles->id !!}" id="{!! $roles->id !!}"  data-class="fa fa-user">{!! ucfirst($roles->name) !!}</option>

                        @endforeach
                        @else
                        @foreach($userRoles as $roles)
                            @if($roles->slug != 'admin')
                                <option value="{!! $roles->id !!}"  id="{!! $roles->id !!}" data-class="fa fa-user">{!! ucfirst($roles->name) !!}</option>
                            @endif
                        @endforeach
                        @endif
                    </select>
                </div>
        </div>
    </div>
</div>




