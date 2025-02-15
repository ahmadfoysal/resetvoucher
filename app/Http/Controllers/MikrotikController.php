<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mikrotik;
use App\Models\User;


class MikrotikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return mikrotiks based on role

        if (auth()->user()->hasRole('admin')) {
            $mikrotiks = Mikrotik::all();
        } else {
            $mikrotiks = auth()->user()->mikrotiks;
        }

        return view('mikrotiks.index', compact('mikrotiks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Get all users for dropdown
        return view('mikrotiks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'ip' => 'required',
            'username' => 'required',
            'password' => 'required',
            'port' => 'required',
            'location' => 'required',
            'user_id' => 'required',
        ]);

        Mikrotik::create($data);

        return redirect()->route('mikrotiks.index')->with('success', 'Mikrotik added successfully');
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
        $mikrotik = MikroTik::findOrFail($id);
        $users = User::all();
        return view('mikrotiks.edit', compact('mikrotik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mikrotik = MikroTik::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|unique:mikrotiks,ip,' . $id,
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'port' => 'required|integer',
            'location' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $mikrotik->name = $request->name;
        $mikrotik->ip = $request->ip;
        $mikrotik->username = $request->username;

        if ($request->filled('password')) {
            $mikrotik->password = $request->password; // Encrypt if needed
        }

        $mikrotik->port = $request->port;
        $mikrotik->location = $request->location;
        $mikrotik->user_id = $request->user_id;

        $mikrotik->save();

        return redirect()->route('mikrotiks.index')->with('success', 'MikroTik server updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mikrotik = MikroTik::findOrFail($id);
        $mikrotik->delete();

        return redirect()->route('mikrotiks.index')->with('success', 'MikroTik server deleted successfully!');
    }
}
