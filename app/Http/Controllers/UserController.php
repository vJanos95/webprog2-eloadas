<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'integer', Rule::in([1, 2])],
        ]);

        $user = new User();
        $user->username = $validated['username'];
        $user->name = $validated['name'];
        $user->email = $validated['email'] ?? null;
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'];
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'A felhasználó sikeresen létrejött.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'integer', Rule::in([1, 2])],
        ]);

        if (
            $user->id === $request->user()->id &&
            (int) $validated['role'] !== (int) $user->role
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'A saját admin jogosultságodat nem módosíthatod.',
                ]);
        }

        if (
            (int) $user->role === 1 &&
            (int) $validated['role'] !== 1 &&
            User::where('role', 1)->count() <= 1
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'Az utolsó adminisztrátor jogosultsága nem vonható vissza.',
                ]);
        }

        $user->username = $validated['username'];
        $user->name = $validated['name'];
        $user->email = $validated['email'] ?? null;
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'A felhasználó adatai sikeresen módosultak.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with(
                'error',
                'A saját felhasználói fiókodat nem törölheted.'
            );
        }

        if (
            (int) $user->role === 1 &&
            User::where('role', 1)->count() <= 1
        ) {
            return back()->with(
                'error',
                'Az utolsó adminisztrátor nem törölhető.'
            );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'A felhasználó sikeresen törölve.');
    }
}