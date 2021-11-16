<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller {

    public function index() {
        $adoptions = Adoption::latest()->unadopted()->get();
        return view('adoptions.list', ['adoptions' => $adoptions, 'header' => 'Available for adoption']);
    }

    public function login() {
        return view('login');
    }

    public function doLogin(Request $request) {
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('status', 'User not valid');
        }

        return redirect()->route('home');

    }

    public function register() {
        return view('register');
    }

    public function doRegister(Request $request) {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);
        User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => bcrypt($request->password)
        ]);

        Auth::attempt($request -> only('email','password'));
        return redirect()->route('home');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
