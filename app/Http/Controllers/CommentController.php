<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($id)
    {
        $room = Room::find($id);
        $comments = Comment::where('room_id', '=', $id)
            ->orderBy("id", "desc")->paginate(20);
        return view('comments.index')
            ->with('room', $room)
            ->with('comments', $comments);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'room_id' => 'required'
        ]);

        // Create comment
        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->room_id = $request->input('room_id');
        $comment->user_id = Auth::user()->id;
        $comment->save();
        
        return redirect()->back()->with('success', 'تمت إضافة تعليقك');
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('comments.edit')
            ->with('comment', $comment);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);

        // Create comment
        $comment->comment = $request->input('comment');
        $comment->user_id = Auth::user()->id;
        $comment->save();
        
        return redirect('/index/'.$comment->room_id)->with('success', 'تم تعديل التعليق');
    }

    public function destroy(Comment $comment)
    {
        //Check if post exists before deleting
        if (!isset($comment)) {
            return redirect()->back()->with('error', 'التعليق غير موجودة');
        }
        
        $comment->delete();
        return redirect()->back()->with('success', 'تم حذف التعليق');
    }

}
