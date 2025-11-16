<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role; 
class RegisteredUserController extends Controller
{
   
    public function create(): View
    {
        return view('admin.create-user');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    // Create user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // 🔹 Assign default role
    // If your registration form allows selecting a role:
    if ($request->has('role') && Role::where('name', $request->role)->exists()) {
        $user->assignRole($request->role);
    } else {
        // Otherwise assign a default role (like 'user')
        $user->assignRole('user');
    }

    // Optionally log them in after registration
    auth()->login($user);

    return redirect()->route('dashboard')->with('success', 'Registration successful!');
}
}