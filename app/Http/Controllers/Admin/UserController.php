<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        
        return view('admin.system.users.index', compact('users'));
    }
    
    public function create()
    {
        return view('admin.system.users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,editor,viewer']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.system.users.index')
                        ->with('success', 'User created successfully.');
    }
    
    public function show(User $user)
    {
        return view('admin.system.users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        return view('admin.system.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,editor,viewer'],
            'is_active' => ['boolean']
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->boolean('is_active', true)
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.system.users.index')
                        ->with('success', 'User updated successfully.');
    }
    
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.system.users.index')
                            ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.system.users.index')
                        ->with('success', 'User deleted successfully.');
    }
    
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'You cannot deactivate your own account.'], 400);
        }

        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success' => true,
            'status' => $user->is_active,
            'message' => 'User status updated successfully.'
        ]);
    }
}
