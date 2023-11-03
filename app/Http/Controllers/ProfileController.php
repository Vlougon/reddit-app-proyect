<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PHPUnit\Framework\MockObject\Generator\OriginalConstructorInvocationRequiredException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'imageUpload' => 'required|file|image|max:200'
        ]);

        if ($request->imageUpload) {
            $path = $request->file('imageUpload')->store('images', 'public');

            Profile::updateOrCreate([
                'user_id' => Auth::id(),
                'imageUpload' => $path
            ]);

            return back()->with('success', "Your image has been updated.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        $userProfile = Auth::user()->profile;

        return view('profile/edit', compact('userProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
