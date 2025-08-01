<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function panitiaIndex()
    {
        $user = Auth::user();
        return view('dashboard.profile.index', compact('user'));
    }

    public function pesertaIndex()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'),[
            'title' => 'Post Categories',
            'active' => ''
        ]);
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
    public function panitiaEdit(User $user)
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', compact('user'));
    }

    public function pesertaEdit(User $user)
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'),[
            'title' => 'Post Categories',
            'active' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function panitiaUpdate(Request $request, User $user)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'birthDate' => 'required|date',
            'image'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete($user->image);
            }
            $validated['image'] = $request->file('image')->store('profile-images');
        }

        $user->update($validated);

        return redirect()->route('dashboard.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function pesertaUpdate(Request $request, User $user)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'birthDate' => 'required|date',
            'image'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete($user->image);
            }
            $validated['image'] = $request->file('image')->store('profile-images');
        }

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
