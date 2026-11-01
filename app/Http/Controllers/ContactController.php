<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Kapcsolati űrlap megjelenítése
    public function create()
    {
        return view('contact.create');
    }

    // Üzenet validálása és mentése
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => 'A név megadása kötelező.',
            'email.required' => 'Az e-mail cím megadása kötelező.',
            'email.email' => 'Érvényes e-mail címet adj meg.',
            'subject.required' => 'A tárgy megadása kötelező.',
            'message.required' => 'Az üzenet megadása kötelező.',
            'message.max' => 'Az üzenet legfeljebb 5000 karakter lehet.',
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('contact.create')
            ->with('success', 'Az üzenetedet sikeresen elküldtük. Köszönjük!');
    }

    // Üzenetek listázása
    public function index()
    {
        $messages = ContactMessage::latest()->get();

        return view('messages.index', compact('messages'));
    }
}