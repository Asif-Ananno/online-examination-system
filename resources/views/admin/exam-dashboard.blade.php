@extends('layout/admin-layout')

@section('space-work')
<h2 class="mb-4">Exams</h2>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModal">
  Add Exam
</button>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject</th>
            <th>Date</th>
            <th>time</th>
        </tr>
    </thead>
        <tbody>
            @if(count($exams)>0)
                @foreach($exams as $exam)
                    <tr>
                        <td>{{$exam->id}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->subjects[0]['subject']}}</td>
                        <td>{{$exam->date}}</td>
                        <td>{{$exam->time}} hrs</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan ="5">Exam not found</td>
                </tr>

            @endif
        </tbody>

</table>

<!-- Modal -->
<div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    
                <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Exam</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id = 'addExam'> 
                 @csrf 
                <div class="modal-body">
                        <label>Subject</label>
                        <input type="text" name="exam_name" placeholder="Enter Exam Name" class= 'w-100'required>
                        <br><br>
                        <select name="subject_id" required class='w-100'>
                            <option value="">Select Subject</option>
                            @if(count($subjects)>0)
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                @endforeach

                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date"  class= 'w-100'required min="@php echo date('Y-m-d'); @endphp">
                        <br><br>
                        <input type="time" name="time"  class= 'w-100'required>

                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Exam</button>
                </div>
                </form>
                </div>
    
  </div>
</div>
<script>
    $(document).ready(function(){
        $("#addExam").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('addExam') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }
                    else{
                        alert(data.msg);
                    }

                }
            });
        });
    });
</script>
@endsection