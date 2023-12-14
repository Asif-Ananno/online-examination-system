<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\ExamAnswer;

class AdminController extends Controller
{
    //
    public function addSubject(Request $request){
    

        try{

            Subject::insert([
                'subject' => $request->subject
            ]);

            return response()->json(['success'=>true,'msg'=>'Subject added successfully']);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }
//edit subject
public function editSubject(Request $request){
    try {
        $subject = Subject::find($request->id);

        if ($subject) {
            $subject->subject = $request->subject;
            $subject->save();
            return response()->json(['success' => true, 'msg' => 'Subject updated successfully']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Subject not found']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
}

public function deleteSubject(Request $request){
    

    try{
        Subject::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'msg'=>'Subject deleted successfully']);
    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };
}

//examdashboard
 public function examDashboard(){
    
   $subjects = Subject::all();
   $exams = Exam::with('subjects')->get();
    return view('admin.exam-dashboard',['subjects'=>$subjects,'exams'=>$exams ]);
 }

 //add exam
 public function addExam(Request $request){
    try{
        $unique_id = uniqid('exid');
        Exam::insert([
            'exam_name' => $request -> exam_name,
            'subject_id' => $request -> subject_id,
            'date' => $request -> date,
            'time' => $request -> time,
            'attempt' => $request -> attempt,
            'entrance_id'=> $unique_id 
        ]);
        return response()->json(['success'=>true,'msg'=>'Exam added successfully']);
    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };
 }
 public function getExamDetail($id){
    try{
       $exam = Exam::where('id',$id)->get();
        return response()->json(['success'=>true,'data'=>$exam]);
    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };

 }
 public function updateExam(Request $request){
    try{
       $exam = Exam::find($request->exam_id);
       $exam->exam_name = $request->exam_name;
       $exam->subject_id = $request->subject_id;
       $exam->date = $request->date;
       $exam->time = $request->time;
       $exam->attempt = $request->attempt;
       $exam->save();
        return response()->json(['success'=>true,'msg'=>'Data updated successfully']);
    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };

 }

 public function deleteQna(Request $request){
    Question::where('id',$request->id)->delete();
    Answer::where('question_id',$request->id)->delete();
    return response()->json(['success'=>true,'msg'=>'Question answers deleted successfully']);
 }

 public function qnaDashboard(){
   $questions = Question::with('answers')->get();
    return view('admin.qnaDashboard',compact('questions'));
 }

 //addqna
 public function addQna(Request $request){
    try{
        $question_Id = Question::insertGetId([
            'question' => $request->question,
            'subject' => $request->subject,
        ]);
        foreach($request->answers as $answer){
            $is_correct = 0;
            if($request->is_correct == $answer ){
                $is_correct = 1;
            }
            Answer::insert([
                'question_id' => $question_Id, 
                'answer' => $answer, 
                'is_correct' => $is_correct, 

            ]);

        }
        
        return response()->json(['success'=>true,'msg'=>'Subject added successfully']);
    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };

 }

 public function getQnaDetails(Request $request){
    $qna =Question::where('id',$request->qid)->with('answers')->get();
    return response()->json(['data'=>$qna]);
 }

 // add qna in exam dashboard
 public function getQuestions(Request $request){
    try{
       $questions = Question::all();
       if(count($questions)>0){
        $data = [];
        $counter = 0;
        foreach($questions as $question ){
           $qnaExam = QnaExam::where(['exam_id'=>$request->exam_id,'question_id'=>$question->id])->get();
           if(count($qnaExam)==0){
            $data[$counter]['id'] = $question->id;
            $data[$counter]['questions'] = $question->question;
            $counter++;
           }

        }
        return response()->json(['success'=>true,'msg'=>"Question data","data"=>$data]);

       }
       else{
        return response()->json(['success'=>false,'msg'=>"Question not found"]);

       }
    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };    


 }
 public function addQuestions(Request $request){
    try{
       if(isset($request->question_ids)){
        foreach($request->question_ids as $qids){
            QnaExam::insert([
                'exam_id'=>$request->exam_id,
                'question_id'=>$qids
            ]);

        }
       }
       return response()->json(['success'=>true,'msg'=>"Question Added successfully"]);
    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };


 }

 public function deleteAns(Request $request){
    Answer::where('id',$request->id)->delete();
    return response()->json(['success'=>true,'msg'=>"Answer deleted successfully"]);

 }

 public function updateQna(Request $request){
    try{
        Question::where('id',$request->question_id)->update([
            'question'=>$request->question
        ]);
        if(isset($request->answers)){

            foreach($request->answers as $key => $value){
                $is_correct =0;
                if($request->is_correct==$value){
                    $is_correct =1;
                }
                Answer::where('id',$key)->update([
                    'question_id' =>$request->question_id,
                    'answer' =>$value,
                    'is_correct'=> $is_correct
                ]);
            }

        }
        if(isset($request->new_answers)){

            foreach($request->new_answers as $answer){
                $is_correct =0;
                if($request->is_correct==$answer){
                    $is_correct =1;
                }
                Answer::insert([
                    'question_id' =>$request->question_id,
                    'answer' =>$answer,
                    'is_correct'=> $is_correct

                ]);
            }

        }
        return response()->json(['success'=>true,'msg'=>"Qna updated successfully details"]);

    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };
 }

 public function getExamQuestions(Request $request){
    try{
       $data= QnaExam::where('exam_id',$request->exam_id)->with('question')->get();
        return response()->json(['success'=>true,'msg'=>"Question details",'data'=>$data]);

    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };
 }
 public function deleteExamQuestions(Request $request){
    try{
       QnaExam::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'msg'=>"Question deleted"]);

    }catch(\Exception $e){
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    };
 }
//delete exam
public function deleteExam(Request $request){
    try{
        Exam::where('id',$request->exam_id)->delete();
         return response()->json(['success'=>true,'msg'=>"Exam deleted"]);
 
     }catch(\Exception $e){
         return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
     };

}

public function loadMarks(){
   $exams = Exam::with('getQnaExam')->get();
    return view('admin.marksDashboard',compact('exams'));
}

public function updateMarks(Request $request){
    try{
        Exam::where('id',$request->exam_id)->update([
            'marks' => $request->marks
        ]);
        return response()->json(['success'=>true,'msg'=>"Marks updated successfully"]);
 
     }catch(\Exception $e){
         return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
     };

  }

  public function reviewExams(){
    $attempts = ExamAttempt::with(['user','exam'])->orderBy('id')->get();

    return view("admin.review-exams",compact('attempts'));

  }

  public function reviewQna(Request $request){
    try{
        $attemptData= ExamAnswer::where('attempt_id',$request->attempt_id)->with(['question','answers'])->get();
        return response()->json(['success'=>true,'data'=>$attemptData]);
 
     }catch(\Exception $e){
         return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
     };

   

  }

  public function approvedQna(Request $request){
    try{
        $attemptId = $request->attempt_id;
        $examData = ExamAttempt::where('id',$attemptId)->with('exam')->get();
        $marks = $examData[0]['exam']['marks'];

        $attemptData = ExamAnswer::where('attempt_id',$attemptId )->with('answers')->get();

        $totalMarks = 0;

        if(count($attemptData)>0){
            foreach($attemptData as $attempt){
                if($attempt->answers->is_correct == 1){
                    $totalMarks += $marks;
                }
            }


        }
        $feedback = $request->feedback;
        ExamAttempt::where('id',$attemptId)->update([
            'status' => 1,
            'marks' =>$totalMarks,
            'feedback' => $feedback
        ]);
      
        return response()->json(['success'=>true,'msg'=>'Approved Successfully']);
 
     }catch(\Exception $e){
         return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
     };
  }

}
