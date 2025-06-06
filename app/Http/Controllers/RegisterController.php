<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index',[
        'title' => 'Register',
        'active' => 'register'
    ]);
    
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name'      => 'required|max:255',
            'firstname' => 'required|max:255',
            'lastname'  => 'required|max:255',
            'email'     => 'required|email:dns|unique:users',
            'birthDate' => 'required|date',
            'password'  => 'required|min:5|max:255'
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan Login');    
    }
}
