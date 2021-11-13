<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $adoptions = Adoption::latest()->unadopted()->get();
        return view('adoptions.list', ['adoptions' => $adoptions, 'header' => 'Available for adoption']);
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if (!auth()->attempt($request->only('email', 'password'))){
            return back()->with('status', 'User not valid');
        }

        return redirect()->route('home');

    }

    public function register()
    {
        return view('register');
    }

    public function doRegister(Request $request)
    {
        /*
        |-----------------------------------------------------------------------
        | Task 2 Guest, step 5. You should implement this method as instructed
        |-----------------------------------------------------------------------
        */
    }

    public function logout()
    {
        /*
        |-----------------------------------------------------------------------
        | Task 2 User, step 3. You should implement this method as instructed
        |-----------------------------------------------------------------------
        */
    }
}
