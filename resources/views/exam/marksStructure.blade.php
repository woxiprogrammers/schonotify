   <div class="row">
       <table style="overflow: scroll" border="1" width="100%">
            <tr>
                <th>Students Name:</th>
                <th>Students Roll Number:</th>
                @for($i=0 ; $i<=count($termDetails) ; $i++) //$i=0
                <th>{{$termDetails['exam_type']}} <input type="checkbox" class="checked_{{$i}}_{{$termDetails['id']}}"></th>
                @endfor
            </tr>
           <tr>
               <td></td>
               <td></td>
               @foreach($termDetails as $terms)
               <td>{{$terms['out_of_marks']}}</td>
                @endforeach
           </tr>
           @foreach($StudentsDetails as $students)
           <tr>
               <td>{{$students['first_name']}} {{$students['last_name']}}</td>
               <td>{{$students['roll_number']}}</td>
                @for($i=0 ; $i<=count($termDetails) ; $i++)
               <td><input type="text" name="marks[]_{{$students['roll_number']}}" class="checked_{{$i}}_{{$termDetails['id']}}"></td>
               @endfor
           </tr>
           @endforeach
       </table>
   </div>
