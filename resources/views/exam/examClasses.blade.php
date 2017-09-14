    @foreach($classes as $class)
            <div class="checkbox clip-check check-primary"><input type="checkbox" value={{$class['id']}} id={{$class['id']}} name="classes[]" ><label for={{$class['id']}}>{{$class['class_name']}}</label></div>
    @endforeach
