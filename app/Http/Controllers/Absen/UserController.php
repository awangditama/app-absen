<?php

namespace App\Http\Controllers\Absen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'nip' => 'required|numeric',
            'email' => 'required',
            'jabatan' => 'required',
            'password' => 'required'
        ]);

        
        $data = $request->except('_token');
        
        $isEmailExist = User::where('email',$request->email)->exists();
        $isNipExist = User::where('nip',$request->nip)->exists();
        
        if($isEmailExist || $isNipExist){
            return back()->withErrors([
                'email' => 'this email already exist',
                'nip' => 'this nip already exist'
            ]);
        }

        $data['password'] = Hash::make($request->password);
        
        User::create($data);

        return redirect()->route('user.login')->with('success', "Berhasil Register");
        
    }

    public function auth(Request $request){
        $data = $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('nip','password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->route('user.dashboard');
        }else{
            return back()->withErrors([
                'credentials' => 'your nip and password are wrong'
            ])->withInput();
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    
    }
}


