<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\Comments;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\TeacherAccounts;
use App\Models\TeacherComments;
use App\Models\UsefulActivity;
use App\Models\Users;
use Illuminate\Http\Request;

class TeacherComment extends Controller
{

    function getBorrowerBeginYear($grade){
        $year = date('Y') + 543;
        $begin_year = $year - (int) $grade + 1;
        return $lastTwoDigits = substr($begin_year, -2);
    }

    function calculateGrade($student_id){
        $date = date('Y') + 543;
        $firstTwoDigits = floor($date / 100);
        $buddhistCurrentYear = intval(floor($date));
        $beginYear = intval($firstTwoDigits . substr($student_id, 0, 2));
        $grade = ($buddhistCurrentYear - $beginYear) + 1;
        return $grade;
    }

    public function index(Request $request){
        $user_id = $request->session()->get('user_id', '2');
        $select_grade = $request->session()->get('select_grade', 'all');
        $request->session()->put('select_grade', $select_grade);
        $teacher = TeacherAccounts::join('users', 'users.id', '=', 'teacher_accounts.user_id')
            ->join('faculties', 'teacher_accounts.faculty_id', '=', 'faculties.id')
            ->join('majors', 'teacher_accounts.major_id', '=', 'majors.id')
            ->where('teacher_accounts.user_id', $user_id)
            ->select([
                'users.prefix as prefix',
                'users.firstname as firstname',
                'users.lastname as lastname',
                'faculties.faculty_name as faculty_name',
                'majors.major_name as major_name',
                'faculties.id as faculty_id',
                'majors.id as major_id'])
            ->first();

        if($select_grade == 'all'){
            $borrower_documents = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
            ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id')
            ->where('documents.id', 1)
            ->where('borrower_documents.status', 'wait-teacher-comment')
            ->where('borrowers.faculty_id', $teacher->faculty_id)
            ->where('borrowers.major_id', $teacher->major_id)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
            ->orderBy('delivered_date', 'asc')
            ->get();
        }else{
            $borrower_documents = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
            ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id')
            ->where('documents.id', 1)
            ->where('borrower_documents.status', 'wait-teacher-comment')
            ->where('borrowers.faculty_id', $teacher->faculty_id)
            ->where('borrowers.major_id', $teacher->major_id)
            ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade).'%')
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
            ->orderBy('delivered_date', 'asc')
            ->get();
        }

        foreach($borrower_documents as $borrower_document){
            $borrower_document['grade'] = $this->calculateGrade($borrower_document['student_id']);
        }
        

        // dd($borrower_documents);
        return view('teachers.index',compact('teacher','borrower_documents'));
    }

    public function selectGrade($grade, Request $request){
        $request->session()->put('select_grade', $grade);
        return redirect('/teacher/index');
    }

    public function commnetBorrowerDocument($borrower_document_id, Request $request){
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $borrower = Borrower::join('users', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties' ,'faculties.id', '=', 'borrowers.faculty_id')
            ->join('majors' ,'majors.id', '=', 'borrowers.major_id')
            ->join('borrower_apprearance_types' ,'borrower_apprearance_types.id', '=', 'borrowers.borrower_appearance_id')
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'borrower_apprearance_types.title',
                'borrowers.birthday',
                'borrowers.student_id',
                'borrowers.phone',
                'borrowers.gpa',
                'borrowers.birthday',
                'faculties.faculty_name',
                'majors.major_name',
            )
            ->where('user_id',$borrower_document['user_id'])
            ->first();
        $document = DocTypes::join('documents','doc_types.id','=','documents.doctype_id')
            ->where('documents.isactive',true)
            ->where('documents.id', $borrower_document['document_id'])
            ->first();
        $useful_activities = UsefulActivity::where('user_id', $borrower_document['user_id'])->get();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $borrower_document['user_id'])
            ->where('document_id', $borrower_document['document_id'])
            ->sum('hour_count') ?? 0 ;
        $useful_activities_hours = Config::where('variable','useful_activity_hour')->value('value');
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id',$borrower_document['document_id'])
            ->select('child_documents.*')
            ->get();
        $comments = TeacherComments::where('isactive', true)->get();
        foreach($child_documents as $child_document){
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents' ,'borrower_files.id' ,'=', 'borrower_child_documents.borrower_file_id')
            ->where('borrower_child_documents.document_id', $document->id)
            ->where('borrower_child_documents.child_document_id', $child_document['id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->first();
        }

        return view('teachers.comment_documents', 
            compact(
                'document',
                'borrower',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_documents',
                'comments',
            ));
    }
}
