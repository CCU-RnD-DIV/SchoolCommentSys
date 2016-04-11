<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User\User;
use App\Comment\Comment;
use Symfony\Component\HttpFoundation\File\File;

class AdminController extends Controller
{
    public function General () {
        return view('general.index');
    }

    public function Console () {
        return view('console.process');
    }

    public function viewProcess () {
        $comment_detail = Comment::where('sid', Auth::user()->account)->orderBy('resp_time', 'DESC')->get();
        return view('general.process', compact('comment_detail'));
    }

    public function viewNewProcess () {
        $comment_detail = Comment::where('reply_OK', 0)->orwhere('reply_OK', 1)->orwhere('reply_OK', 2)->orderBy('resp_time', 'DESC')->get();
        $comment_new_count = Comment::where('reply_OK', 0)->count();
        $comment_admin_count = Comment::where('reply_OK', 2)->count();
        $navi_status = 1;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_new_count', 'comment_admin_count'));
    }

    public function viewAdminProcess () {
        $comment_detail = Comment::where('reply_OK', 0)->orwhere('reply_OK', 1)->orwhere('reply_OK', 2)->orderBy('resp_time', 'DESC')->get();
        $comment_new_count = Comment::where('reply_OK', 0)->count();
        $comment_admin_count = Comment::where('reply_OK', 2)->count();
        $navi_status = 2;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_new_count', 'comment_admin_count'));
    }
    public function viewAllProcess () {
        $comment_detail = Comment::orderBy('resp_time', 'DESC')->get();
        $comment_new_count = Comment::where('reply_OK', 0)->count();
        $comment_admin_count = Comment::where('reply_OK', 2)->count();
        $navi_status = 3;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_new_count', 'comment_admin_count'));
    }
    
    public function viewCertainProcess ($id) {

        $user = User::where('account', Auth::user()->account)->get();
        $user_auth = $user[0] -> auth;
        
        if($user_auth == 0) { // ADMIN

            $comment_detail = Comment::where('id', $id)->get();
            $comment_user_detail = User::where('account', $comment_detail[0] -> sid)->get();

            if($comment_detail[0] -> id != ''){
                return view('common.viewComment', compact('comment_detail', 'user_auth', 'comment_user_detail'));
            }else{
                return redirect('console/viewAllProcess');
            }

        }else{

            $comment_detail = Comment::where('id', $id)->where('sid', Auth::user()->account)->get();
            $comment_user_detail = User::where('account', $comment_detail[0] -> sid)->get();

            if($comment_detail[0] -> id != ''){
                return view('common.viewComment', compact('comment_detail', 'user_auth', 'comment_user_detail'));
            }else{
                return redirect('general/viewProcess');
            }

        }
        
    }
    
    public function AddComment () {
        $now = Carbon::now();
        $user_detail = User::where('account', Auth::user()->account)->get();
        return view('general.addComment', compact('now', 'user_detail'));
    }
    public function AddCommentCancel (Requests\CancelCheck $request) {

        $user_detail = User::where('account', Auth::user()->account)->get();

        Comment::where('id', $request -> get('comment_id'))
            ->where('sid', $user_detail[0] -> account )
            ->update([
                'cancel' => 1,
                'cancel_time' => Carbon::now()
            ]);
        return redirect('general/viewProcess');
    }

    public function AddCommentStore (Requests\CommentCheck $request) {
        $now = Carbon::now();
        $user_detail = User::where('account', Auth::user()->account)->get();
        
        $input = new Comment;
        $input -> sid = Auth::user()->account;
        $input -> topic = $request -> get('topic');
        $input -> resp_text = $request -> get('resp-text');
        $input -> resp_expect = $request -> get('resp-expect');
        $input -> resp_time = Carbon::now();

        if ($request -> file('resp-attachment')) {

            $attachmentName = rand(100000,999999) . '-' . $input -> sid . '-' . $input -> resp_time . '.' .
                $request->file('resp-attachment')->getClientOriginalExtension();

            $request->file('resp-attachment')->move(
                base_path() . '/public/upload/attachments/', $attachmentName
            );

            $input -> resp_attachment = $attachmentName;

        } else {

            $input -> resp_attachment = '';

        }

        $input -> reply_attachment = '';
        $input -> reply_major = '';
        $input -> reply_OK = 0;
        $input -> cancel = 0;
        $input -> cancel_time = '';
        $input -> cellphone = $request -> get('cellphone');
        $input -> email = $request -> get('email');


        $input->save();
        
        return redirect('general/viewProcess');
    }
    
    public function commentReply (Requests\ReplyCheck $request){

        if ($request -> file('reply-attachment')) {

            $attachmentName = rand(100000,999999) . '-' . $request -> get('comment_id') . '-' . Carbon::now() . '.' .
                $request->file('reply-attachment')->getClientOriginalExtension();

            $request->file('reply-attachment')->move(
                base_path() . '/public/upload/attachments/', $attachmentName
            );

        } else {

            $attachmentName = '';

        }
        
        Comment::where('id', $request -> get('comment_id'))
            ->update([
                'reply_attachment' => $attachmentName,
                'reply_text' => $request -> get('reply-text'),
                'reply_OK' => 3,
                'updated_at' => Carbon::now()
            ]);

        return redirect('/console/viewAllProcess');
        
    }
    
    public function commentAssign (Requests\CommentAssignCheck $request){
        Comment::where('id', $request -> get('id'))
            ->update([
                'reply_major' => $request->get('reply-major[]'),
                'reply_OK' => 1,
                'updated_at' => Carbon::now()
            ]);
        return redirect('/console/viewAllProcess');
    }

    public function modifyStatus (Requests\StatusCheck $request){
        Comment::where('id', $request -> get('comment_id'))
            ->update([
                'reply_OK' => $request->get('status'),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/console/viewAllProcess');
    }

}
