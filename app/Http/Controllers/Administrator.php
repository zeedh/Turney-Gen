<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Administrator extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10); // <= pagination 10 per halaman
        return view('dashboard.admin.index', 
        compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.admin.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules =[
            'name' => 'required|max:255',
            'password'    => 'required|min:5|max:255'
            // 'category_id' => 'required',
            // 'tournament_id' => 'required',
            // 'image' => 'image|file|max:1024',
            // 'body' => 'required'
        ];

        $validatedData = $request->validate($rules);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::where('id', $user->id)
        ->update($validatedData);

        return redirect('/dashboard/admin')->with('success', 'Data user telah diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hindari menghapus user admin diri sendiri, kalau perlu
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Kamu tidak bisa menghapus dirimu sendiri!');
        }

        $user->delete();

        return redirect('/dashboard/admin')->with('success', 'User berhasil dihapus.');
    }
}
