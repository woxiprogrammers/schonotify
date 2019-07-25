<div class="form-group" id="DivisionBlock">
    <label class="control-label">
        Subject
    </label>
    <select class="form-control" id="classSubjectdropdown" name="classSubjectdropdown" style="-webkit-appearance: menulist;">
        <option value="">Select Subject</option>
        @if(!empty($subjectData))
            @foreach($subjectData as $subject)
                <option value="{!! $subject->id !!}">{!! $subject->subject_name !!}</option>
            @endforeach
        @endif
    </select>
</div>
