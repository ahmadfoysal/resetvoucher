<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('superadmin')) {
            // Get all Admins
            $users = User::role('admin')->get();
        } else {
            $users = auth()->user()->users;
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the request...

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //add api token
        $data['api_token'] = bin2hex(random_bytes(30));

        $data['admin_id'] = auth()->id();

        $user = User::create($data);

        if (auth()->user()->hasRole('superadmin')) {
            $user->assignRole('admin');
        } else {
            $user->assignRole('user');
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'reset_mode' => 'required|in:manual,list',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->reset_mode = $request->reset_mode;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function loginAs($id)
    {
        $superAdmin = Auth::user(); // Store the original Super Admin

        // Ensure only Super Admin can impersonate
        if (!$superAdmin->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id); // Find the target user

        if ($user->hasRole('superadmin')) {
            return redirect()->route('dashboard')->with('error', 'You cannot impersonate another Super Admin.');
        }

        // Store the original Super Admin ID in session to allow switching back
        session(['original_user_id' => $superAdmin->id]);

        // Log in as the selected user
        Auth::login($user);

        return redirect()->route('index.reset')->with('success', 'Now logged in as ' . $user->name);
    }


    public function switchBack()
    {
        $originalUserId = session('original_user_id'); // Get stored Super Admin ID

        // If no original Super Admin is stored, deny access
        if (!$originalUserId) {
            return redirect()->route('dashboard')->with('error', 'You are not impersonating any user.');
        }

        // Find the original Super Admin
        $originalUser = User::find($originalUserId);

        if (!$originalUser || !$originalUser->hasRole('superadmin')) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized switch back attempt.');
        }

        // Log back in as the Super Admin
        Auth::login($originalUser);

        // Clear the session data to prevent misuse
        session()->forget('original_user_id');

        return redirect()->route('users.index')->with('success', 'Switched back to Super Admin successfully.');
    }
}
