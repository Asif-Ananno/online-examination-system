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
//admin-edit-delete
            <th>Add Question</th>
            //main
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
//admin-edit-delete
                        <td>
                            <a href="#" class="addQuestion" data-id="{{$exam->id}}" data-toggle="modal" data-target="#addQnaModal">Add Question</a>
                        </td>
                        //main
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
//admin-edit-delete

<!--Add Answer Modal -->
<div class="modal fade" id="addQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    
                <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Q&A</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id = 'addQna'> 
                 @csrf 
                <div class="modal-body">
                    <input type="hidden" name="exam_id" id="addExamId">
                    <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100" placeholder="Search here">
                    <br><br>
                    <table class="table" id="questionsTable">
                        <thead>
                            <th>Select</th>
                            <th>Question</th>
                        </thead>
                        <tbody class="addBody">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A</button>
                </div>
                </form>
                </div>
    
  </div>
</div>
//
//main
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
//admin-edit-delete

        //assigning question
        $(".addQuestion").click(function(){
            var id = $(this).attr('data-id');
            $("#addExamId").val(id);

            $.ajax({
                url:"{{ route('getQuestions')}}",
                type: "GET",
                data:{exam_id:id},
                success:function(data){
                    if(data.success==true){
                        var questions = data.data;
                        var html ='';
                        if(questions.length>0){
                            for(let i=0;i<questions.length;i++){
                                html+= `
                                <tr>
                                    <td><input type="checkbox" value="`+questions[i]['id']+`" name="question_ids[]"></td>
                                    <td>`+questions[i]['questions']+`</td>
                                    
                                </tr>
                                `;

                            }

                        }
                        else{
                            html+=`
                                <tr>
                                    <td colspan="2">Question not availbale</td>
                                </tr>
                            `;

                        }

                        $(".addBody").html(html);
                    }
                    else{
                        alert(data.msg);
                    }
                }

            });
        });
        $('#addQna').submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                     url:"{{route('addQuestions')}}",
                     type: "POST",
                     data: formData,
                     success:function(data){
                        if(data.success==true){
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


<script>
    function searchTable(){
        var input,filter, table,tr,td,i,txtValue;

        input = document.getElementById('search');
        filter = input.value.toUpperCase();
        table = document.getElementById('questionsTable');
        tr = document.getElementsByTagName("tr");
        for(i=0;i<tr.length;i++){
            td = tr[i].getElementsByTagName("td")[1];
            if(td){
                txtValue = td.textContent || td.innerText;
                if(txtValue.toUpperCase().indexOf(filter)>-1){
                    tr[i].style.display="";

                }
                else{
                    tr[i].style.display="none";
                }

            }

        }


    }
    
</script>
    });
</script>
//main
@endsection