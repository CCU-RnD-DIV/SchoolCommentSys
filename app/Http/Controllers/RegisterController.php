<?php

namespace App\Http\Controllers;

use App\User\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class RegisterController extends Controller
{
    public function generalReg() {
        return view('general.reg');
    }

    public function generalRegPost(Requests\RegCheck $request) {
        $user = new User();
        $user->account = $request->input('account');
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->dept = $request->input('dept', 4104);
        $user->auth = 1;
        $user->save();

        return redirect('/generalLogin');
    }
}
