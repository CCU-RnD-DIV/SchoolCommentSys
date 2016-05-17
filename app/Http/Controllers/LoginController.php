<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Input;
use DOMDocument;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function generalLogin (){

        if(config('environment.studentManualLogin')){
            $showManualLogin = true;
        }else{
            $showManualLogin = false;
        }
        Auth::logout();
        return view('general.login', compact('showManualLogin'));


    }

    public function consoleLogin (){

        Auth::logout();
        return view('console.login');


    }

    /**
     * 單一入口登入
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getPermission(Request $request)
    {

        if (! is_null(config('environment.sso_url')) && $request->has(['miXd', 'ticket'])) {
            $username = $this->ssoAuth($request->input('miXd'), $request->input('ticket'));

            $aca_user_detail = DB::connection('pgsql')
                ->table('a11vstd_rec_tea')
                ->select("a11vstd_rec_tea.id AS stu_id",
                    "a11vstd_rec_tea.name AS stu_name",
                    "a11vstd_rec_tea.deptcd AS stu_dept_id",
                    "a11vstd_rec_tea.grade AS stu_grade",
                    "a11vstd_rec_tea.class AS stu_class")
                ->where("a11vstd_rec_tea.id", $username)->first();
            
            if ($username !== false) {
                if(User::where('account', $username)->count() == 0) {
                    $input = new User;
                    $input -> account = $username;
                    $input -> password = 'youCannotLoginByGeneralLoginInterface';
                    $input -> dept = $aca_user_detail -> stu_dept_id;
                    $input -> name = $aca_user_detail -> stu_name;
                    $input -> auth = 1;
                    $input -> save();
                }
                $username = User::select('id')->whereAccount($username)->first();
                Auth::loginUsingId($username->id);
                return redirect('/general');
            }
        }
        return view('general.login');
    }
    /**
     * SSO Auth
     *
     * @param string $miXd
     * @param string $ticket
     * @return bool|string
     */
    protected function ssoAuth($miXd, $ticket)
    {
        $response = (new Client())->get(config('environment.sso_url'), ['query' => ['cid' => $miXd, 'ticket' => $ticket]]);
        $dom = new DOMDocument();
        if ($dom->loadXML(preg_replace('/<enter.*time>/', '', $response->getBody()->getContents()))
            && false !== ($data = simplexml_import_dom($dom))
            && ('Y' === (string) $data->sess_alive)) {

            return (string) $data->person_id;
        }
        return false;
    }


    public function CheckGeneralLogin (Requests\LoginCheck $request){

        if (Auth::attempt(['account' => $request->get('account'), 'password' => $request->get('password')])){

            return redirect('/general');
        }

        $loginFailed = true;

        return view('general.login', compact('loginFailed'));

    }

    public function CheckConsoleLogin (Requests\LoginCheck $request){

        if (Auth::attempt(['account' => $request->get('account'), 'password' => $request->get('password')])){

            return redirect('/console/viewNewProcess');
        }

        $loginFailed = true;

        return view('console.login', compact('loginFailed'));

    }
}
