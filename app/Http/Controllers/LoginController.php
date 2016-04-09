<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;


class LoginController extends Controller
{

    public function generalLogin (){

        Auth::logout();
        return view('general.login');


    }

    public function consoleLogin (){

        Auth::logout();
        return view('console.login');


    }

    public function CheckGeneralLogin (Requests\LoginCheck $request){

        if (Auth::attempt(['account' => $request->get('account'), 'password' => $request->get('password')])){

            return redirect('/general');
        }

        $loginFailed = true;

        return view('auth.generalLogin', compact('loginFailed'));

    }

    public function CheckConsoleLogin (Requests\LoginCheck $request){

        if (Auth::attempt(['account' => $request->get('account'), 'password' => $request->get('password')])){

            return redirect('/console/viewAllProcess');
        }

        $loginFailed = true;

        return view('auth.consoleLogin', compact('loginFailed'));

    }
}
