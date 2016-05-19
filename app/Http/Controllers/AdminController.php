<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User\User;
use App\Comment\Comment;
use App\Comment\FileAttachments;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    
    public function General () {
        return view('general.index');
    }

    public function Console () {
        return redirect('/console/viewNewProcess');
    }

    public function viewProcess () {
        $comment_detail = Comment::where('sid', Auth::user()->account)->orderBy('resp_time', 'DESC')->paginate(50);
        return view('general.process', compact('comment_detail'));
    }

    public function viewNewProcess () {
        $comment_detail = Comment::where('cancel', '<>', '1')->where('reply_OK', 0)->orwhere('reply_OK', 1)->orwhere('reply_OK', 2)->orderBy('resp_time', 'DESC')->paginate(50);
        $comment_count[0] = $this->getProcessCount(0);
        $comment_count[2] = $this->getProcessCount(2);
        $comment_count[3] = $this->getProcessCount(3);
        $comment_count[4] = $this->getProcessCount(4);
        $navi_status = 1;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_count'));
    }
    public function viewFinishedProcess () {
        $comment_detail = Comment::where('reply_OK', 3)->orderBy('resp_time', 'DESC')->paginate(50);
        $comment_count[0] = $this->getProcessCount(0);
        $comment_count[2] = $this->getProcessCount(2);
        $comment_count[3] = $this->getProcessCount(3);
        $comment_count[4] = $this->getProcessCount(4);
        $navi_status = 4;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_count'));
    }
    public function viewAdminProcess () {
        $comment_detail = Comment::where('reply_OK', 0)->orwhere('reply_OK', 1)->orwhere('reply_OK', 2)->orderBy('resp_time', 'DESC')->paginate(50);
        $comment_count[0] = $this->getProcessCount(0);
        $comment_count[2] = $this->getProcessCount(2);
        $comment_count[3] = $this->getProcessCount(3);
        $comment_count[4] = $this->getProcessCount(4);
        $navi_status = 2;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_count'));
    }
    public function viewAllProcess () {
        $comment_detail = Comment::orderBy('resp_time', 'DESC')->paginate(50);
        $comment_count[0] = $this->getProcessCount(0);
        $comment_count[2] = $this->getProcessCount(2);
        $comment_count[3] = $this->getProcessCount(3);
        $comment_count[4] = $this->getProcessCount(4);
        $navi_status = 3;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_count'));
    }

    public function viewDenyProcess () {
        $comment_detail = Comment::where('reply_OK', 4)->orwhere('reply_OK', 5)->orderBy('resp_time', 'DESC')->paginate(50);
        $comment_count[0] = $this->getProcessCount(0);
        $comment_count[2] = $this->getProcessCount(2);
        $comment_count[3] = $this->getProcessCount(3);
        $comment_count[4] = $this->getProcessCount(4);
        $navi_status = 5;
        return view('console.process', compact('comment_detail', 'navi_status', 'comment_count'));
    }

    /**
     * getProcessCount
     *
     * @param integer $type
     * @return integer
     */

    protected function getProcessCount($type) {
        if ($type == 0){
            return Comment::where('reply_OK', 0)->orwhere('reply_OK', 1)->orwhere('reply_OK', 2)->count();
        } elseif ($type == 2) {
            return Comment::where('reply_OK', 2)->count();
        } elseif ($type == 3) {
            return Comment::where('reply_OK', 3)->count();
        } elseif ($type == 4) {
            return Comment::where('reply_OK', 4)->orwhere('reply_OK', 5)->count();
        } else {
            return 0;
        }
    }
    
    public function viewCertainProcess ($id) {

        $user = User::where('account', Auth::user()->account)->get();
        $user_auth = $user[0] -> auth;



        if($user_auth == 0) { // ADMIN

            $comment_detail = Comment::where('id', $id)->get();

            //if (!isset($comment_detail[0]->id)) return redirect('/console');

            $aca_user_detail = DB::connection('pgsql')
                ->table('a11vstd_rec_tea')
                ->select("a11vstd_rec_tea.id AS stu_id",
                    "a11vstd_rec_tea.name AS stu_name",
                    "a11vstd_rec_tea.deptcd AS stu_dept_id",
                    "a11vstd_rec_tea.grade AS stu_grade",
                    "a11vstd_rec_tea.class AS stu_class")
                ->where("a11vstd_rec_tea.id", $comment_detail[0] -> sid)->get();

            if (isset($aca_user_detail[0]->stu_dept_id)) {
                $dept_alias = DB::connection('pgsql')
                    ->table('h0rtunit_a_')
                    ->select("name", "abbrev")
                    ->where("cd", $aca_user_detail[0]->stu_dept_id)->get();
            }

            $comment_attachments = FileAttachments::where('comments_id', $id)->get();
            $comment_user_detail = User::where('account', $comment_detail[0] -> sid)->get();

            if($comment_detail[0] -> id != ''){
                return view('common.viewComment', compact('comment_detail', 'user_auth', 'comment_user_detail', 'comment_attachments', 'aca_user_detail', 'dept_alias'));
            }else{
                return redirect('console/viewAllProcess');
            }

        }else{

            $comment_detail = Comment::where('id', $id)->where('sid', Auth::user()->account)->get();

            //if (!($comment_detail[0]->has('id'))) return redirect('/general');

            $aca_user_detail = DB::connection('pgsql')
                ->table('a11vstd_rec_tea')
                ->select("a11vstd_rec_tea.id AS stu_id",
                    "a11vstd_rec_tea.name AS stu_name",
                    "a11vstd_rec_tea.deptcd AS stu_dept_id",
                    "a11vstd_rec_tea.grade AS stu_grade",
                    "a11vstd_rec_tea.class AS stu_class")
                ->where("a11vstd_rec_tea.id", Auth::user()->account)->get();

            if (isset($aca_user_detail[0]->stu_dept_id)) {
                $dept_alias = DB::connection('pgsql')
                    ->table('h0rtunit_a_')
                    ->select("name", "abbrev")
                    ->where("cd", $aca_user_detail[0]->stu_dept_id)->get();
            }
            
            $comment_attachments = FileAttachments::where('comments_id', $id)->get();
            $comment_user_detail = User::where('account', $comment_detail[0] -> sid)->get();

            if($comment_detail[0] -> id != ''){
                return view('common.viewComment', compact('comment_detail', 'user_auth', 'comment_user_detail', 'comment_attachments', 'aca_user_detail', 'dept_alias'));
            }else{
                return redirect('general/viewProcess');
            }

        }
        
    }
    
    public function AddComment () {

        $now = Carbon::now();
        $user_detail = User::where('account', Auth::user()->account)->get();
        $aca_user_detail = DB::connection('pgsql')
            ->table('a11vstd_rec_tea')
            ->select("a11vstd_rec_tea.id AS stu_id",
                "a11vstd_rec_tea.name AS stu_name",
                "a11vstd_rec_tea.deptcd AS stu_dept_id",
                "a11vstd_rec_tea.grade AS stu_grade",
                "a11vstd_rec_tea.class AS stu_class",
                "a11vstd_rec_tea.email AS stu_email")
            ->where("a11vstd_rec_tea.id", Auth::user()->account)->get();

        $aca_user_detail_phone = DB::connection('pgsql')
            ->table('a11vstd_all')
            ->select("a11vstd_all.cellur_no AS cellphone")
            ->where("a11vstd_all.std_no", Auth::user()->account)->get();

        if (isset($aca_user_detail[0]->stu_dept_id)) {
            $dept_alias = DB::connection('pgsql')
                ->table('h0rtunit_a_')
                ->select("name", "abbrev")
                ->where("cd", $aca_user_detail[0]->stu_dept_id)->get();
        }

        return view('general.addComment', compact('now', 'user_detail', 'aca_user_detail', 'dept_alias', 'aca_user_detail_phone'));
    }
    public function AddCommentCancel (Requests\CancelCheck $request) {

        $user_detail = User::where('account', Auth::user()->account)->get();

        Comment::where('id', $request -> get('comment_id'))
            ->where('sid', $user_detail[0] -> account )
            ->update([
                'reply_OK' => -1,
                'cancel' => 1,
                'cancel_time' => Carbon::now()
            ]);
        return redirect('general/viewProcess');
    }

    public function dataUsageANC () {
        return view('general.dataUsageANC');
    }

    public function AddCommentStore (Requests\CommentCheck $request) {

        $now = Carbon::now();

        $user_detail = User::where('account', Auth::user()->account)->get();
        $hash = md5(Auth::user()->account.$request -> get('topic').$request -> get('resp-text'));

        /*if (Comment::where('hash', $hash)->count() > 0) {
            return redirect('general/viewProcess');
        }*/

        $input = new Comment;
        $input -> sid = Auth::user()->account;
        $input -> topic = $request -> get('topic');
        $input -> resp_text = $request -> get('resp-text');
        $input -> resp_expect = $request -> get('resp-expect');
        $input -> resp_time = $now;
        $input -> reply_major = '';
        $input -> reply_OK = 0;
        $input -> cancel = 0;
        $input -> cancel_time = '';
        $input -> cellphone = $request -> get('cellphone');
        $input -> email = $request -> get('email');
        $input -> hash = $hashFileUse = $hash;

        $input -> save();

        $comment_detail = Comment::where('hash', $hashFileUse)->get();

        $files[0] = $request -> file('resp-attachment1');
        $files[1] = $request -> file('resp-attachment2');
        $files[2] = $request -> file('resp-attachment3');
        $files[3] = $request -> file('resp-attachment4');
        $files[4] = $request -> file('resp-attachment5');

        for ($i = 0; $i < 5; $i++){

            if (isset($files[$i])) {
                $attachmentName = rand(1000000, 9999999) . '-' . $input->sid . '-' . $input->resp_time . '.' .
                    $files[$i]->getClientOriginalExtension();

                $desName = $files[$i]->getClientOriginalName();

                $files[$i]->move(
                    base_path() . '/public/upload/attachments/', $attachmentName
                );

                $upload = new FileAttachments;
                $upload->comments_id = $comment_detail[0]->id;
                $upload->attachment = $attachmentName;
                $upload->attachment_type = 0;
                $upload->file_des = $desName;

                $upload->save();
            }

        }

        if (config('environment.mailEnable')) {
            Mail::send('common.viewCommentEmail', ['comment_detail' => $comment_detail, 'comment_user_detail' => $user_detail], function($message) use ($comment_detail)
            {
                $message->from('k12cc@ccu.edu.tw', '校務建言系統');
                $message->to(config('environment.primaryReceiver'))->cc(config('environment.secondaryReceiver'))
                    ->cc(config('environment.testReceiver'))->subject('新建言：'.$comment_detail[0]->topic);
                $message->to(config('environment.testReceiver'))->subject('新建言：'.$comment_detail[0]->topic);
            });
        }else{
            Mail::send('common.viewCommentEmail', ['comment_detail' => $comment_detail, 'comment_user_detail' => $user_detail], function($message) use ($comment_detail)
            {
                $message->from('k12cc@ccu.edu.tw', '校務建言系統');
                $message->to(config('environment.testReceiver'))->subject('新建言：'.$comment_detail[0]->topic);
            });
        }

        
        return redirect('general/viewProcess');
    }
    
    public function commentReply (Requests\ReplyCheck $request){

        Comment::where('id', $request -> get('comment_id'))
            ->update([
                'reply_OK' => $request->get('status'),
                'updated_at' => Carbon::now()
            ]);

        if ($request->get('status') != 1) {
            $files[0] = $request->file('resp-attachment1');
            $files[1] = $request->file('resp-attachment2');
            $files[2] = $request->file('resp-attachment3');
            $files[3] = $request->file('resp-attachment4');
            $files[4] = $request->file('resp-attachment5');

            for ($i = 0; $i < 5; $i++) {

                if (isset($files[$i])) {
                    $attachmentName = rand(100000, 999999) . '-' . $request->get('comment_id') . '-' . Carbon::now() . '.' .
                        $files[$i]->getClientOriginalExtension();

                    $desName = $files[$i]->getClientOriginalName();

                    $files[$i]->move(
                        base_path() . '/public/upload/attachments/', $attachmentName
                    );

                    $upload = new FileAttachments;
                    $upload->comments_id = $request->get('comment_id');
                    $upload->attachment = $attachmentName;
                    $upload->attachment_type = 1;
                    $upload->file_des = $desName;

                    $upload->save();
                }

            }
        }


        Comment::where('id', $request -> get('comment_id'))
            ->update([
                'reply_text' => $request -> get('reply-text'),
                'reply_OK' => $request->get('status'),
                'reply_time' => Carbon::now(),
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

}
