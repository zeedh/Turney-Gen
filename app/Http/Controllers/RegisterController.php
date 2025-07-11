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
    public function Panitia(){
        return view('register.panitia',[
        'title' => 'Register Peserta',
        'active' => 'register'
    ]);
    
    }

    public function Peserta(){
        return view('register.peserta',[
        'title' => 'Register Peserta',
        'active' => 'register'
    ]);
    
    }


    public function storePanitia(Request $request)
    {
        $validatedData = $request->validate([
            // HAPUS 'name' di sini
            'firstname'   => 'required|max:255',
            'lastname'    => 'required|max:255',
            'email'       => 'required|email:dns|unique:users,email',
            'birthDate'   => 'required|date',
            'gender'      => 'required|in:M,F',
            'is_panitia'  => 'required|boolean',
            'password'    => 'required|min:5|max:255',
        ]);

        // Buat name = firstname + lastname
        $validatedData['name'] = $validatedData['firstname'] . ' ' . $validatedData['lastname'];

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan ke database
        User::create($validatedData);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    public function storePeserta(Request $request)
    {
        $validatedData = $request->validate([
            // HAPUS 'name' di sini
            'firstname'   => 'required|max:255',
            'lastname'    => 'required|max:255',
            'email'       => 'required|email:dns|unique:users,email',
            'birthDate'   => 'required|date',
            'gender'      => 'required|in:M,F',
            'is_panitia'  => 'required|boolean',
            'password'    => 'required|min:5|max:255',
        ]);

        // Buat name = firstname + lastname
        $validatedData['name'] = $validatedData['firstname'] . ' ' . $validatedData['lastname'];

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan ke database
        User::create($validatedData);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }


}
