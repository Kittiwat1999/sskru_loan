<?php

namespace App\Http\Controllers;

use App\Models\BorrowerDocument;
use App\Models\Comments;
use App\Models\TeacherComments;
use App\Models\Users;
use Illuminate\Http\Request;

class CacheAndCommentController extends Controller
{
    private function getBorrowerDocuments()
    {
        $borrower_documents = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
        ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
        ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
        ->join('doc_types', 'documents.doctype_id', '=', 'doc_types.id')
        ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
        ->join('majors', 'borrowers.major_id', '=', 'majors.id')
        ->where('borrower_documents.checking', true)
        ->select(
            'users.prefix', 
            'users.firstname', 
            'users.lastname', 
            'borrowers.student_id', 
            'borrower_documents.id', 
            'borrower_documents.status', 
            'borrower_documents.delivered_date', 
            'faculties.faculty_name', 
            'majors.major_name',
            'documents.term',
            'documents.year',
            'doc_types.doctype_title',
        )
        ->distinct()
        ->get();
        return $borrower_documents;
    }

    private function validateComment($request)
    {
        $validate_data = $request->validate(
            [
                'comment' => 'required|max:255'
            ],
            [
                'comment.required' => 'กรุณากรอกความเห็น',
                'comment.max' => 'ความเห็นต้องไม่เกิน :max ตัวอักษร'
            ]
        );
        return $validate_data;
    }

    public function index(Request $request)
    {
        $borrower_documents = $this->getBorrowerDocuments();
        $teacher_comments = TeacherComments::where('isactive', true)->get();
        $comments = Comments::where('isactive', true)->get();
        return view('admin.cache_and_comment', compact('borrower_documents', 'teacher_comments', 'comments'));
    }

    public function clearBorrowerDocumentCache($borrower_document_id)
    {
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $borrower_document['checking'] = false;
        $borrower_document->save();
        return redirect()->back()->with(['success' => 'เคลีย 1 แคชสำเร็จ']);
    }

    public function clearBorrowerDocumentCacheAll()
    {
        BorrowerDocument::where('checking', true)->update(['checking' =>  false]);
        return redirect()->back()->with(['success' => 'เคลียแคชทั้งหมดสำเร็จ']);
    }

    public function editTeacherComment(Request $request, $teacher_comment_id)
    {
        $validate_data = $this->validateComment($request);
        $teacher_comment = TeacherComments::find($teacher_comment_id);
        $teacher_comment['comment'] = $validate_data['comment'];
        $teacher_comment->save();
        return redirect()->back()->with(['success' => 'แก้ไขความคิดเห็นแล้ว']);
    }

    public function addTeacherComment(Request $request)
    {
        $validate_data = $this->validateComment($request);
        $teacher_comment = new TeacherComments();
        $teacher_comment['comment'] = $validate_data['comment'];
        $teacher_comment['isactive'] = true;
        $teacher_comment->save();
        return redirect()->back()->with(['success' => 'เพิ่มความคิดเห็นแล้ว']);
    }

    public function deleteTeacherComment($teacher_comment_id)
    {
        $teacher_comment = TeacherComments::find($teacher_comment_id);
        $teacher_comment['isactive'] = false;
        $teacher_comment->save();
        return redirect()->back()->with(['success' => 'ลบความคิดเห็นแล้ว']);
    }

    public function editComment(Request $request, $comment_id)
    {
        $validate_data = $this->validateComment($request);
        $_comment = Comments::find($comment_id);
        $_comment['comment'] = $validate_data['comment'];
        $_comment->save();
        return redirect()->back()->with(['success' => 'แก้ไขความคิดเห็นแล้ว']);
    }

    public function addComment(Request $request)
    {
        $validate_data = $this->validateComment($request);
        $comment = new Comments();
        $comment['comment'] = $validate_data['comment'];
        $comment['isactive'] = true;
        $comment->save();
        return redirect()->back()->with(['success' => 'เพิ่มความคิดเห็นแล้ว']);
    }

    public function deleteComment($comment_id)
    {
        $comment = Comments::find($comment_id);
        $comment['isactive'] = false;
        $comment->save();
        return redirect()->back()->with(['success' => 'ลบความคิดเห็นแล้ว']);
    }
}
