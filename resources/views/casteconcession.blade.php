
   <select name="caste">
       <option>Select Caste</option>
    @foreach($query as $castes)
    <option id="{{$castes['id']}}" class="form-control" value="{{$castes['id']}}" >{{$castes['caste_category']}}</option>
    @endforeach
   </select>